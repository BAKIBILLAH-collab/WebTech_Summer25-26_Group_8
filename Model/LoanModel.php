<?php

require_once __DIR__ . '/Database.php';

class LoanModel
{
    public function getLoanById(int $customerId, int $loanId): ?array
    {
        $statement = Database::connect()->prepare(
            "SELECT l.loan_id, l.book_id, b.title, b.author, l.borrow_date, l.due_date,
                    l.return_date, l.renewed_count, l.status
             FROM loans l INNER JOIN books b ON b.book_id = l.book_id
             WHERE l.customer_id = :customer_id AND l.loan_id = :loan_id
               AND l.status IN ('active', 'overdue')"
        );
        $statement->execute(['customer_id' => $customerId, 'loan_id' => $loanId]);

        $loan = $statement->fetch();
        return $loan !== false ? $loan : null;
    }

    public function getCurrentLoans(int $customerId): array
    {
        $statement = Database::connect()->prepare(
                "SELECT l.loan_id, l.book_id, b.title, b.author, b.category,
                    l.borrow_date, l.due_date, l.return_date, l.renewed_count,
                    CASE WHEN l.due_date < CURRENT_DATE THEN 'overdue' ELSE l.status END AS status
             FROM loans l
             INNER JOIN books b ON b.book_id = l.book_id
             WHERE l.customer_id = :customer_id AND l.status IN ('active', 'overdue')
             ORDER BY l.due_date"
        );
        $statement->execute(['customer_id' => $customerId]);

        return $statement->fetchAll();
    }

    public function getHistory(int $customerId, string $status, ?string $fromDate, ?string $toDate): array
    {
        $conditions = ['l.customer_id = :customer_id'];
        $parameters = ['customer_id' => $customerId];

        if ($status !== 'all') {
            $conditions[] = ($status === 'overdue'
                ? "(l.status = 'overdue' OR (l.status = 'active' AND l.due_date < CURRENT_DATE))"
                : 'l.status = :status');
            if ($status !== 'overdue') {
                $parameters['status'] = $status;
            }
        }
        if ($fromDate !== null) {
            $conditions[] = 'l.borrow_date >= :from_date';
            $parameters['from_date'] = $fromDate;
        }
        if ($toDate !== null) {
            $conditions[] = 'l.borrow_date <= :to_date';
            $parameters['to_date'] = $toDate;
        }

           $sql = "SELECT l.loan_id, b.title, b.author, b.category, l.borrow_date,
                    l.return_date, l.due_date,
                    CASE WHEN l.due_date < CURRENT_DATE AND l.status = 'active'
                     THEN 'overdue' ELSE l.status END AS status,
                    CASE WHEN l.status = 'returned' OR l.due_date >= CURRENT_DATE THEN 0
                         ELSE DATEDIFF(CURRENT_DATE, l.due_date) * 10 END AS fine
             FROM loans l
             INNER JOIN books b ON b.book_id = l.book_id
               WHERE " . implode(' AND ', $conditions) . "
               ORDER BY l.borrow_date DESC";
           $statement = Database::connect()->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchAll();
    }

    public function borrow(int $customerId, int $bookId, string $borrowDate, string $dueDate): bool
    {
        $database = Database::connect();
        $database->beginTransaction();

        try {
            $bookStatement = $database->prepare(
                'UPDATE books SET available_copies = available_copies - 1
                 WHERE book_id = :book_id AND available_copies > 0'
            );
            $bookStatement->execute(['book_id' => $bookId]);

            if ($bookStatement->rowCount() !== 1) {
                $database->rollBack();
                return false;
            }

            $loanStatement = $database->prepare(
                'INSERT INTO loans (customer_id, book_id, borrow_date, due_date, status)
                 VALUES (:customer_id, :book_id, :borrow_date, :due_date, \'active\')'
            );
            $loanStatement->execute([
                'customer_id' => $customerId,
                'book_id' => $bookId,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
            ]);
            $database->commit();
            return true;
        } catch (Throwable $exception) {
            $database->rollBack();
            throw $exception;
        }
    }

    public function renew(int $customerId, int $loanId, string $newDueDate): bool
    {
        $statement = Database::connect()->prepare(
            "UPDATE loans
             SET due_date = :due_date, renewed_count = renewed_count + 1, status = 'active'
             WHERE loan_id = :loan_id AND customer_id = :customer_id
               AND status IN ('active', 'overdue') AND renewed_count < 3"
        );
        $statement->execute([
            'due_date' => $newDueDate,
            'loan_id' => $loanId,
            'customer_id' => $customerId,
        ]);

        return $statement->rowCount() === 1;
    }

    public function returnBook(int $customerId, int $loanId, string $returnDate): bool
    {
        $database = Database::connect();
        $database->beginTransaction();

        try {
            $loanStatement = $database->prepare(
                "UPDATE loans SET return_date = :return_date, status = 'returned'
                 WHERE loan_id = :loan_id AND customer_id = :customer_id
                   AND status IN ('active', 'overdue')"
            );
            $loanStatement->execute([
                'return_date' => $returnDate,
                'loan_id' => $loanId,
                'customer_id' => $customerId,
            ]);

            if ($loanStatement->rowCount() !== 1) {
                $database->rollBack();
                return false;
            }

            $bookStatement = $database->prepare(
                'UPDATE books b INNER JOIN loans l ON l.book_id = b.book_id
                 SET b.available_copies = b.available_copies + 1
                 WHERE l.loan_id = :loan_id'
            );
            $bookStatement->execute(['loan_id' => $loanId]);
            $database->commit();
            return true;
        } catch (Throwable $exception) {
            $database->rollBack();
            throw $exception;
        }
    }
}
