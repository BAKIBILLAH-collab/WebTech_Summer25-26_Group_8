<?php

require_once __DIR__ . '/../Model/BookModel.php';

class BookController
{
    private BookModel $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function search(string $search, string $category): array
    {
        return $this->bookModel->getBooks($search, $category);
    }
}
