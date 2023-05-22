<?php
include 'session.php';

$username = $_SESSION['username'];

if (isset($_GET['to'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user_from = $stmt->fetch();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $_GET['to']]);
        $user_to = $stmt->fetch();

        $stmt = $pdo->prepare("SELECT messages.*, users.username FROM messages JOIN users ON messages.from_user_id = users.id WHERE (from_user_id = :user_from_id AND to_user_id = :user_to_id) OR (from_user_id = :user_to_id AND to_user_id = :user_from_id) ORDER BY message_timestamp DESC");
        $stmt->execute(['user_from_id' => $user_from['id'], 'user_to_id' => $user_to['id']]);
        $messages = $stmt->fetchAll();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $username = $row['username'];
            $message = $row['message'];
            echo "<div class='message'>";
            echo "<p>$username: $message</p>";
            echo "</div>";
        }
    } catch (PDOException) {
        header('location: login.php?error=internal_server_error');
    }
}

if (isset($_POST['message']) && isset($_POST['user_id'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user_from = $stmt->fetch();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $_GET['to']]);
        $user_to = $stmt->fetch();

        $stmt = $pdo->prepare("INSERT INTO messages(from_user_id, to_user_id, message, message_timestamp) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_from['id'], $user_to['id'], $_POST['message'], time()]);

        header('location: im_message.php?to='.$user_to['username']);
    } catch (PDOException) {
        header('location: login.php?error=internal_server_error');
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/chat.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title> Страница пользователя </title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand"> Navbar </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="user.php"> Личная страница</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="user_list.php"> Список пользователей </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="logout.php" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Настройки
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="delete_user.php"> Удалить аккаунт </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"> Выйти </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="bg-light">
    <div class="container">
        <h3 class="display-3 text-center my-3">Сообщения</h3>

        <?php if (!empty($_GET['to'])) { ?>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="mesgs">
                    <div class="msg_history">
                        <?php
                        foreach ($messages as $message) {
                            if ($message['to_user_id'] != $user_to['id']) {
                                echo "<div class='incoming_msg'>";
                                echo "<div class='received_msg'>";
                                echo "<div class='received_withd_msg'>";
                                echo "<p>";
                                echo $message['message'];
                                echo "</p>";
                                echo "</div>";
                            } else {
                                echo "<div class='outgoing_msg'>";
                                echo "<div class='sent_msg'>";
                                echo "<p>";
                                echo $message['message'];
                                echo "</p>";
                            }

                            echo "</div></div>";
                        }
                        ?>
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <form method="post">
                                <input type="text" name="message" class="write_msg" placeholder="Введите сообщение"/>
                                <input type="hidden" name="user_id" value="<?php echo $user_to['id'] ?>">
                                <button type="submit" class="msg_send_btn"> -> </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div>
            <p> Ошибка !</p>
        </div>
        <?php } ?>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>
