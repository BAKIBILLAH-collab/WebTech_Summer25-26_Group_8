<?php
require_once __DIR__ . '/Model/app.php';
header('Content-Type: application/json; charset=utf-8');

try {
    [$database, $conn] = getDatabase();
    $keyword = trim($_GET['q'] ?? '');

    if ($keyword === '') {
        $stmt = $conn->prepare("SELECT id, title, author, category, available_copies FROM books ORDER BY title ASC");
    } else {
        $search = "%" . $keyword . "%";
        $stmt = $conn->prepare("SELECT id, title, author, category, available_copies FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ? ORDER BY title ASC");
        $stmt->bind_param('sss', $search, $search, $search);
    }

    if (!$stmt || !$stmt->execute()) {
        throw new Exception('Database search failed.');
    }

    $result = $stmt->get_result();
    $books = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $database->close();

    echo json_encode(['success'=>true,'message'=>count($books).' book(s) found.','books'=>$books]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>$e->getMessage(),'books'=>[]]);
}
?>
