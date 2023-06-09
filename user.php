<?php
include 'session.php';

$username = $_GET['username'] ?? $_SESSION['username'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

    $stmt = $pdo->prepare('SELECT username, email, first_name, last_name, registration_date, role FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);

    $user = $stmt->fetch();
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
                        <?php if (isset($user) && $user['role'] == 'admin') { ?>
                        <li><a class="dropdown-item" href="admin.php"> Админ-панель </a></li>
                        <?php } ?>
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
        <div class="d-flex align-items-center" style="height: 100vh;">
            <div class="row mx-auto">
                <div class="col">
                    <div class="card-header">
                        <?php if (isset($user) && $user) { ?>
                            <p class="display-4 text-center">
                                <?php echo $user['first_name'] . " " . $user['last_name'] ?>
                            </p>
                            <?php if ($user['role'] == 'admin') { ?>
                                <div class="text-center">
                                <span class="badge bg-success text-center"
                                      title="Данный пользователь является администратором">Admin</span>
                                </div>
                            <?php } ?>
                            <p class="h3 text-center mt-3">
                                <?php echo "Email: " . $user['email'] ?>
                            </p>
                            <p class="h3 text-center mt-3">
                                <?php echo "Дата регистрации: " . $user['registration_date'] ?>
                            </p>
                            <?php if (isset($_GET['username'])) { ?>
                                <div class="text-center">
                                    <a href="im_message.php?to=<?php echo $_GET['username'] ?>" class="btn btn-primary">
                                        Написать сообщение
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="display-4 text-center"> Пользователь не найден </p>
                        <?php } ?>
                    </div>
                    <?php if (isset($_GET['error']) && $_GET['error'] == 'forbidden') { ?>
                        <div class="alert alert-danger text-center"> У вас нет прав </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>
