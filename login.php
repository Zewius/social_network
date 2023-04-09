<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :login OR email = :login');
        $stmt->execute(['login' => $login]);

        $user = $stmt->fetch();

        if ($user && $password == $user['passwd']) {
            // Авторизация прошла успешно
            session_start();
            $_SESSION['username'] = $user['username'];
            header('Location: user.php');
        } else {
            // Авторизация не удалась
            header('Location: login.php?error=forbidden');
        }
    } catch (PDOException) {
        header("Location: login.php?error=internal_server_error");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title> Авторизация </title>
</head>

<body>

<header class="bg-light">
    <div class="container">
        <div class="d-flex align-items-center" style="height: 100vh;">
            <div class="row mx-auto">
                <div class="col">
                    <div class="card-header">
                        <h1 class="display-1 text-center mb-5"> Социальная сеть </h1>
                        <p class="display-4 text-center"> Авторизация </p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="login" class="form-label"> Логин </label>
                                <input type="text" name="login" id="login" required="required"
                                       placeholder="Введите имя пользователя или email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"> Пароль </label>
                                <input type="password" name="password" id="password" required="required"
                                       placeholder="Введите пароль" class="form-control">
                            </div>
                            <div class="form-group text-center my-4">
                                <input type="submit" value="Авторизоваться" class="btn btn-primary">
                            </div>
                        </form>

                        <?php if (isset($_GET['error']) && $_GET['error'] == 'internal_server_error') { ?>
                            <div class="alert alert-danger text-center">
                                Внутренняя ошибка сервера, повторите попытку позже!
                            </div>
                        <?php } ?>
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'forbidden') { ?>
                            <div class="alert alert-danger text-center"> Неверный логин или пароль!</div>
                        <?php } ?>

                        <div class="text-center">
                            <a href="register.php"> Нет учётной записи? Зарегистрироваться! </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
</body>
</html>
