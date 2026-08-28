<?php

require_once __DIR__ . '/Database.php';

class BookModel
{
    public function getBooks(string $search = '', string $category = 'All'): array
    {
        $conditions = [];
        $parameters = [];

        if (trim($search) !== '') {
            $conditions[] = '(title LIKE :search OR author LIKE :search)';
            $parameters['search'] = '%' . trim($search) . '%';
        }

        if ($category !== 'All') {
            $conditions[] = 'category = :category';
            $parameters['category'] = $category;
        }

        $sql = 'SELECT book_id, title, author, category, available_copies FROM books';
        if ($conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY title';

        $statement = Database::connect()->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchAll();
    }

    public function getBookById(int $bookId): ?array
    {
        $statement = Database::connect()->prepare(
            'SELECT book_id, title, author, category, available_copies
             FROM books WHERE book_id = :book_id'
        );
        $statement->execute(['book_id' => $bookId]);

        $book = $statement->fetch();
        return $book !== false ? $book : null;
    }
}
