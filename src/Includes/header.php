<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/style.css">

    <title>Document</title>
</head>
<body>
    <header class='container-fluid'>
        <nav>
            <ul>
                <li><a href="/pwd/shop">Shop</a></li>
                <li><a href="/pwd/cart">Cart</a></li>
                <?php if(isset($_SESSION['user'])): ?>
                    <?php if($_SESSION['user']->getRole() === ['ROLE_ADMIN']): ?>
                        <li><a href="/pwd/admin">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="/pwd/profile">Profile</a></li>
                    <li><a href="/pwd/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/pwd/login">Login</a></li>
                    <li><a href="/pwd/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        


