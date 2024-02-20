<?php
    require_once '../vendor/autoload.php';
    session_start();
    $auth = new App\AuthenticationController();
    $profile = $auth->profile();

    if(!$profile) {
        /* header('Location: login.php'); */
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth->setFullname($name);
        $auth->setEmail($email);
        $auth->setPassword($password);

        if($auth->updateProfile()) {
            header('Location: profile.php');
        }
        else {
            $errorMessage = 'Echec de la mise à jour du profil';
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
    <? if($profile): ?>
        <h1><?= $profile->getFullname() ?></h1>
        <p><?= $profile->getEmail() ?></p>
        <form
            method="post"
        >
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $profile->getFullname() ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $profile->getEmail() ?>">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Update">
        </form>
    <? endif; ?>
</body>
</html>
