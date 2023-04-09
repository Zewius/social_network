<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['username']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $_SESSION['invalid_username'] = "Поле не может быть пустым и может содержать только латинские буквы и цифры";
        header('Location: register.php');
        exit();
    }
    $username = $_POST['username'];

    if (!isset($_POST['firstname']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['firstname'])) {
        $_SESSION['invalid_first_name'] = "Поле не может быть пустым и может содержать только буквы";
        header('Location: register.php');
    }
    $first_name = $_POST['firstname'];

    if (!isset($_POST['lastname']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['lastname'])) {
        $_SESSION['invalid_last_name'] = "Поле не может быть пустым и может содержать только буквы";
        header('Location: register.php');
    }
    $last_name = $_POST['lastname'];

    $birth_day = $_POST['birth_day'];

    if (!isset($_POST['email']) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['invalid_email'] = "Поле не может быть пустым и может содержать только валидный email-адрес";
        header('Location: register.php');
    }
    $email = $_POST['email'];

    if (!isset($_POST['password']) || !preg_match('/^.{6,12}$/', $_POST['password'])) {
        $_SESSION['invalid_password'] = "Поле не может быть пустым и может содержать только от 6 до 12 символов";
        header('Location: register.php');
    }
    if (!isset($_POST['confirm']) || $_POST['password'] != $_POST['confirm']) {
        $_SESSION['invalid_confirm'] = "Значение данного поля не совпадает с полем для ввода пароля";
    }
    $password = md5($_POST['password']);

    $registration_date = date('Y-m-d H:i:s');
    $role = 'user';

    $pdo = new PDO('mysql:host=localhost;dbname=bib', 'root', '');

    // TODO: Хранить в базе дату рождения
    $query = 'INSERT INTO users (username, first_name, last_name, email, passwd, registration_date, role) 
              VALUES (?,?,?,?,?,?,?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $first_name, $last_name, $email, $password, $registration_date, $role]);

    $_SESSION['username'] = $username;

    header('location: user.php');
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
    <title> Регистрация </title>
</head>

<body>

<header class="bg-light">
    <div class="container">
        <div class="d-flex align-items-center" style="height: 100vh;">
            <div class="row mx-auto">
                <div class="col">
                    <div class="card-header">
                        <h1 class="display-1 text-center mb-5"> Социальная сеть </h1>
                        <p class="display-4 text-center"> Регистрация </p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="register.php">
                            <div class="mb-3">
                                <label for="username" class="form-label"> Имя пользователя </label>
                                <input type="text" name="username" id="username" required="required"
                                       placeholder="Введите имя пользователя" class="form-control">
                                <?php if (isset($_SESSION['invalid_username'])) { ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['invalid_username'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label"> Имя </label>
                                <input type="text" name="firstname" id="firstname" required="required"
                                       placeholder="Введите ваше имя" class="form-control">
                                <?php if (isset($_SESSION['invalid_first_name'])) { ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['invalid_first_name'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label"> Фамилия </label>
                                <input type="text" name="lastname" id="lastname" required="required"
                                       placeholder="Введите вашу фамилию" class="form-control">
                                <?php if (isset($_SESSION['invalid_last_name'])) { ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['invalid_last_name'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label"> Дата рождения </label>
                                <input type="date" name="birthday" id="birthday" required="required"
                                       placeholder="Укажите дату рождения" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"> Электронная почта </label>
                                <input type="text" name="email" id="email" required="required"
                                       placeholder="Введите email" class="form-control">
                                <?php if (isset($_SESSION['invalid_email'])) { ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['invalid_email'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"> Пароль </label>
                                <input type="password" name="password" id="password" required="required"
                                       placeholder="Введите пароль" class="form-control">
                                <?php if (isset($_SESSION['invalid_password'])) { ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['invalid_password'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="confirm" class="form-label"> Повторите пароль </label>
                                <input type="password" name="confirm" id="confirm" required="required"
                                       placeholder="Введите пароль" class="form-control">
                                <?php if (isset($_SESSION['invalid_confirm'])) { ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['invalid_confirm'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group text-center my-4">
                                <input type="submit" value="Зарегистрироваться" class="btn btn-primary">
                            </div>
                        </form>
                        <div class="text-center">
                            <a href="login.php" class="text-center"> Учётная запись уже создана? Авторизоваться</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
</body>
</html>
