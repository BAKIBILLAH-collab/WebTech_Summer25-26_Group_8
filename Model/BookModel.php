<?php

class BookModel
{
    public function getBooks(string $search = '', string $category = 'All'): array
    {
        $books = [
            [
                'title' => 'PHP for Beginners',
                'author' => 'John Smith',
                'category' => 'Technology',
                'available_copies' => 5,
            ],
            [
                'title' => 'Modern JavaScript',
                'author' => 'Emily Brown',
                'category' => 'Technology',
                'available_copies' => 3,
            ],
            [
                'title' => 'World History',
                'author' => 'David Lee',
                'category' => 'History',
                'available_copies' => 2,
            ],
            [
                'title' => 'Billy Summers',
                'author' => 'Stephen King',
                'category' => 'Novel',
                'available_copies' => 4,
            ],
        ];

        $search = strtolower(trim($search));

        return array_values(array_filter($books, function (array $book) use ($search, $category): bool {
            $matchesSearch = $search === ''
                || str_contains(strtolower($book['title']), $search)
                || str_contains(strtolower($book['author']), $search);
            $matchesCategory = $category === 'All' || $book['category'] === $category;

            return $matchesSearch && $matchesCategory;
        }));
    }
}
