<?php
    require_once '../vendor/autoload.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = new App\AuthenticationController();
        $auth->setFullname($name);
        $auth->setEmail($email);
        $auth->setPassword($password);

        if($auth->register()) {
            header('Location: login.php');
        }
        else {
            $errorMessage = 'Un utilisateur avec cet email existe déjà';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $errorMessage ?>
    <form method="post" >
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Register">
    </form>
</body>
</html>