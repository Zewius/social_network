<?php
include 'session.php';

$username = $_SESSION['username'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

    $stmt = $pdo->prepare('SELECT username, email, first_name, last_name, registration_date, role FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);

    $user = $stmt->fetch();

    if ($user['role'] == 'admin') {
        $stmt = $pdo->prepare('SELECT username, role FROM users');
        $stmt->execute();

        $users = $stmt->fetchAll();
    } else {
        // Доступ запрещён
        header('Location: user.php?error=forbidden');
    }
} catch (PDOException) {
    header('location: login.php?error=internal_server_error');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Админка</title>
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
                    <a class="nav-link disabled" href="#"> Сообщения </a>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logout.php"> Выйти </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="bg-light">
    <div class="container">
        <div class="d-flex align-items-center" style="height: 100vh;">
            <div class="row mx-auto">
                <div class="col">
                    <p class="display-4 text-center"> Список пользователей </p>
                    <?php if (isset($users) && $users) { ?>
                        <table class="table">
                            <caption>Таблица пользователей и их роль</caption>
                            <thead>
                            <tr>
                                <th>Имя пользователя</th>
                                <th>Роль</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($users as $user) {
                                echo "<tr>";
                                echo "<td>".$user['username']."</td>";
                                echo "<td>".$user['role']."</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p class="text-center"> Список пуст </p>
                    <?php } ?>
                </div>
                <?php if (isset($_GET['error']) && $_GET['error'] == 'forbidden') { ?>
                    <div class="alert alert-danger text-center"> У вас нет прав</div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
</body>
</html>
