<?php
// Include koneksi database
include 'functions.php';

$pdo = pdo_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah ID disediakan
    if (!isset($_POST['id'])) {
        die('ID not provided');
    }

    $id = $_POST['id'];

    // Query delete
    $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
    $stmt->execute([$id]);

    // Kirim respons JSON
    echo json_encode(['success' => true]);
    exit();
}
?>
