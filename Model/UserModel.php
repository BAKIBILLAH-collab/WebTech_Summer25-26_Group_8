<?php

require_once __DIR__ . '/Database.php';

class UserModel
{
    public function nameExists(string $name): bool
    {
        $statement = Database::connect()->prepare(
            'SELECT customer_id FROM customers WHERE full_name = :name
             UNION ALL
             SELECT staff_id FROM staff_accounts WHERE name = :staff_name'
        );
        $statement->execute([
            'name' => $name,
            'staff_name' => $name,
        ]);

        return $statement->fetch() !== false;
    }

    public function registerCustomer(
        string $name,
        string $email,
        string $phone,
        string $password,
        string $membershipStatus,
        ?string $expiryDate
    ): bool {
        $statement = Database::connect()->prepare(
            'INSERT INTO customers
                (full_name, email, phone_number, password, membership_status, membership_expiry_date)
             VALUES (:name, :email, :phone, :password, :membership_status, :expiry_date)'
        );

        return $statement->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'membership_status' => $membershipStatus,
            'expiry_date' => $expiryDate !== '' ? $expiryDate : null,
        ]);
    }

    public function login(string $name, string $password): ?array
    {
        $database = Database::connect();
        $statement = $database->prepare(
            'SELECT customer_id AS user_id, full_name AS name, password, "customer" AS role
             FROM customers WHERE full_name = :customer_name
             UNION ALL
             SELECT staff_id AS user_id, name, password, role
             FROM staff_accounts WHERE name = :staff_name
             LIMIT 1'
        );
        $statement->execute([
            'customer_name' => $name,
            'staff_name' => $name,
        ]);
        $user = $statement->fetch();

        if ($user === false) {
            return null;
        }

        $passwordMatches = password_verify($password, $user['password']);
        if (!$passwordMatches && hash_equals((string) $user['password'], $password)) {
            $passwordMatches = true;
        }

        if (!$passwordMatches) {
            return null;
        }

        unset($user['password']);
        return $user;
    }

    public function getCustomerById(int $customerId): ?array
    {
        $statement = Database::connect()->prepare(
            'SELECT customer_id, full_name, email, phone_number, membership_status,
                    membership_expiry_date, registered_date
             FROM customers WHERE customer_id = :customer_id'
        );
        $statement->execute(['customer_id' => $customerId]);

        $customer = $statement->fetch();
        return $customer !== false ? $customer : null;
    }

    public function getCustomerByName(string $name): ?array
    {
        $statement = Database::connect()->prepare(
            'SELECT customer_id, full_name, email, phone_number, membership_status,
                    membership_expiry_date, registered_date
             FROM customers WHERE full_name = :name'
        );
        $statement->execute(['name' => $name]);

        $customer = $statement->fetch();
        return $customer !== false ? $customer : null;
    }
}
