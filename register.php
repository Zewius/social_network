<?php
session_start();


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
                        <p class="display-4 text-center"> Регистрация </p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="register.php">
                            <div class="mb-3">
                                <label for="username" class="form-label"> Имя пользователя </label>
                                <input type="text" name="username" id="username" required="required"
                                       placeholder="Введите имя пользователя" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label"> Имя </label>
                                <input type="text" name="firstname" id="firstname" required="required"
                                       placeholder="Введите ваше имя" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label"> Фамилия </label>
                                <input type="text" name="lastname" id="lastname" required="required"
                                       placeholder="Введите вашу фамилию" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"> Электронная почта </label>
                                <input type="text" name="email" id="email" required="required"
                                       placeholder="Введите email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"> Пароль </label>
                                <input type="password" name="password" id="password" required="required"
                                       placeholder="Введите пароль" class="form-control">
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
