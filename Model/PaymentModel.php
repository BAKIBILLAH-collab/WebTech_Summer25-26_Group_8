<?php

require_once __DIR__ . '/Database.php';

class PaymentModel
{
    public function createPayment(
        int $customerId,
        float $amount,
        string $paymentDate,
        string $expiryDate,
        string $receiptNo,
        string $paymentMethod
    ): bool {
        $database = Database::connect();
        $database->beginTransaction();

        try {
            $paymentStatement = $database->prepare(
                'INSERT INTO membership_payments
                    (customer_id, amount, payment_date, expiry_date, receipt_no, payment_method)
                 VALUES (:customer_id, :amount, :payment_date, :expiry_date, :receipt_no, :payment_method)'
            );
            $paymentStatement->execute([
                'customer_id' => $customerId,
                'amount' => $amount,
                'payment_date' => $paymentDate,
                'expiry_date' => $expiryDate,
                'receipt_no' => $receiptNo,
                'payment_method' => $paymentMethod,
            ]);

            $customerStatement = $database->prepare(
                "UPDATE customers SET membership_status = 'active', membership_expiry_date = :expiry_date
                 WHERE customer_id = :customer_id"
            );
            $customerStatement->execute([
                'expiry_date' => $expiryDate,
                'customer_id' => $customerId,
            ]);
            $database->commit();
            return true;
        } catch (Throwable $exception) {
            $database->rollBack();
            throw $exception;
        }
    }

    public function getLatestPayment(int $customerId): ?array
    {
        $statement = Database::connect()->prepare(
            'SELECT amount, payment_date, expiry_date, receipt_no, payment_method
             FROM membership_payments
             WHERE customer_id = :customer_id
             ORDER BY payment_id DESC LIMIT 1'
        );
        $statement->execute(['customer_id' => $customerId]);

        $payment = $statement->fetch();
        return $payment !== false ? $payment : null;
    }

    public function getPayments(int $customerId): array
    {
        $statement = Database::connect()->prepare(
            'SELECT payment_id, amount, payment_date, expiry_date, receipt_no, payment_method
             FROM membership_payments
             WHERE customer_id = :customer_id
             ORDER BY payment_date DESC, payment_id DESC'
        );
        $statement->execute(['customer_id' => $customerId]);

        return $statement->fetchAll();
    }
}
