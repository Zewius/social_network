<?php
include 'session.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

    $stmt = $pdo->prepare('DELETE FROM users WHERE username = :username');
    $stmt->execute(['username' => $_SESSION['username']]);

    unset($_SESSION['username']);

    header('location: login.php?message=account_deleted');
} catch (PDOException) {
    header('location: login.php?error=internal_server_error');
}
