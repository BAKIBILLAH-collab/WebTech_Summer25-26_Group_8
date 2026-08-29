<?php

require_once __DIR__ . '/db.php';

function legacyDatabase(): mysqli
{
    static $connection;

    if (!$connection) {
        $connection = (new db())->connection();
    }

    return $connection;
}

function legacyResult(string $query, array $values = []): mysqli_result|bool
{
    $statement = legacyDatabase()->prepare($query);

    if ($values !== []) {
        $types = str_repeat('s', count($values));
        $statement->bind_param($types, ...$values);
    }

    $statement->execute();
    return $statement->get_result();
}

class CustomerModel
{
    public function checkNameExists(string $name): mysqli_result|bool
    {
        return legacyResult('SELECT customer_id FROM customers WHERE full_name = ?', [$name]);
    }

    public function addCustomer(string $name, string $email, string $phone, string $password, string $expiry): bool
    {
        $statement = legacyDatabase()->prepare(
            'INSERT INTO customers (full_name, email, phone_number, password, membership_status, membership_expiry_date)
             VALUES (?, ?, ?, ?, \'active\', ?)'
        );
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->bind_param('sssss', $name, $email, $phone, $hashedPassword, $expiry);
        return $statement->execute();
    }

    public function checkCustomerExists(string $id): mysqli_result|bool
    {
        return legacyResult('SELECT customer_id FROM customers WHERE customer_id = ?', [$id]);
    }

    public function getAllCustomers(): mysqli_result|bool
    {
        return legacyResult('SELECT customer_id, full_name, email, phone_number, membership_expiry_date, membership_status FROM customers ORDER BY full_name');
    }

    public function searchCustomers(string $search): mysqli_result|bool
    {
        $value = '%' . $search . '%';
        return legacyResult(
            'SELECT customer_id, full_name, email, phone_number, membership_expiry_date, membership_status
             FROM customers WHERE full_name LIKE ? OR customer_id LIKE ? ORDER BY full_name',
            [$value, $value]
        );
    }

    public function renewMembership(string $id, string $expiry): bool
    {
        $statement = legacyDatabase()->prepare(
            'UPDATE customers SET membership_status = \'active\', membership_expiry_date = ? WHERE customer_id = ?'
        );
        $statement->bind_param('ss', $expiry, $id);
        return $statement->execute();
    }
}

class BookModel
{
    public function addBook(string $title, string $author, string $category, string $isbn, string $copies): bool
    {
        $statement = legacyDatabase()->prepare(
            'INSERT INTO books (title, author, category, isbn, total_copies, available_copies) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $statement->bind_param('ssssss', $title, $author, $category, $isbn, $copies, $copies);
        return $statement->execute();
    }

    public function getLastInsertId(): int
    {
        return legacyDatabase()->insert_id;
    }

    public function checkBookExists(string $id): mysqli_result|bool
    {
        return legacyResult('SELECT book_id FROM books WHERE book_id = ?', [$id]);
    }

    public function removeBook(string $id): bool
    {
        $statement = legacyDatabase()->prepare('DELETE FROM books WHERE book_id = ?');
        $statement->bind_param('s', $id);
        return $statement->execute();
    }
}

class FineModel
{
    public function checkCustomerExists(string $id): mysqli_result|bool
    {
        return legacyResult('SELECT customer_id FROM customers WHERE customer_id = ?', [$id]);
    }

    public function payFine(string $id, string $amount, string $method, string $date): bool
    {
        $statement = legacyDatabase()->prepare(
            'INSERT INTO fine_payments (customer_id, amount, payment_method, payment_date, status) VALUES (?, ?, ?, ?, \'paid\')'
        );
        $statement->bind_param('ssss', $id, $amount, $method, $date);
        return $statement->execute();
    }

    public function getAllFinePayments(): mysqli_result|bool
    {
        return legacyResult('SELECT customer_id, amount, payment_method, payment_date, status FROM fine_payments ORDER BY payment_date DESC');
    }

    public function searchFinePayments(string $search): mysqli_result|bool
    {
        $value = '%' . $search . '%';
        return legacyResult(
            'SELECT customer_id, amount, payment_method, payment_date, status FROM fine_payments WHERE customer_id LIKE ? ORDER BY payment_date DESC',
            [$value]
        );
    }
}

class ReturnModel
{
    public function approveReturn(string $bookId, string $customerId, string $issueDate, string $returnDate, string $condition, string $fine): bool
    {
        $statement = legacyDatabase()->prepare(
            'INSERT INTO returns (book_id, customer_id, issue_date, return_date, book_condition, fine) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $statement->bind_param('ssssss', $bookId, $customerId, $issueDate, $returnDate, $condition, $fine);
        return $statement->execute();
    }
}

class MembershipPaymentModel
{
    public function addPayment(string $customerId, string $amount, string $date, string $expiry, string $receipt, string $method): bool
    {
        $statement = legacyDatabase()->prepare(
            'INSERT INTO membership_payments (customer_id, amount, payment_date, expiry_date, receipt_no, payment_method) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $statement->bind_param('ssssss', $customerId, $amount, $date, $expiry, $receipt, $method);
        return $statement->execute();
    }
}

class LibrarianModel
{
    public function getByUsername(string $username): mysqli_result|bool
    {
        return legacyResult('SELECT name FROM staff_accounts WHERE name = ?', [$username]);
    }

    public function checkLogin(string $username, string $password): mysqli_result|bool
    {
        $result = legacyResult('SELECT username, name FROM staff_accounts WHERE username = ? AND role = \'Librarian\' AND password = ?', [$username, $password]);
        return $result;
    }
}
