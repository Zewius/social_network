<?php
include 'session.php';

$username = $_SESSION['username'];

$pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

$user_id = 12;
$recipient_id = 2;
$stmt = $pdo->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.from_user_id = users.id WHERE (from_user_id = :user_id AND to_user_id = :recipient_id) OR (from_user_id = :recipient_id AND to_user_id = :user_id) ORDER BY message_timestamp ASC");
$stmt->execute(['user_id' => $user_id, 'recipient_id' => $recipient_id]);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $username = $row['username'];
    $message = $row['message'];
    echo "<div class='message'>";
    echo "<p>$username: $message</p>";
    echo "</div>";
}
