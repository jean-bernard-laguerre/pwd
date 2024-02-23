<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = new App\AuthenticationController();
        $auth->setFullname($name);
        $auth->setEmail($email);
        $auth->setPassword($password);

        if($auth->register()) {
            header('Location: /pwd/login');
        }
        else {
            $errorMessage = 'Un utilisateur avec cet email existe déjà';
        }
    }
?>


    <?php if(isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>
    <form method="post" >
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Register">
    </form>
