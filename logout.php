<?php
include 'session.php';

unset($_SESSION['username']);

header('location: login.php');
