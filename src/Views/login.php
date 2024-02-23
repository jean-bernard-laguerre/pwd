<?php
    
    $errorMessage = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = new App\AuthenticationController();
        $auth->setEmail($email);
        $auth->setPassword($password);

        if($auth->login()) {
            header('Location: /pwd/shop');
        }
        else {
            $errorMessage = 'Les identifiants fournis ne correspondent à aucun utilisateur';
        }
    }
?>


    <?php if(isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>
    <form
        method="post"
    >
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Login">
    </form>
