<?php namespace App;

    require_once '../vendor/autoload.php';
    session_start();

    $errorMessage = null;
    

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $product = new Product();
        $product = $product->findOneById($id);

        $category = new Category();
        $category = $category->findOneById($product->getIdCategory());
        
        $categoryName = __NAMESPACE__ . "\\" . $category->getName();
        $product = new $categoryName;
        $product = $product->findOneById($id);

        if(!$product) {
            $errorMessage = 'Le produit demandé n\'est pas disponible';
        }
    }

    else {
        $errorMessage = 'Aucun produit n\'a été demandé';
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['quantity'])) {
            $shop = new ShopController();
            $shop->setUser($_SESSION['user']);
            $shop->addProductToCart($_POST['quantity'], $product->getId());
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
    <div>
        <?php if(isset($product)): ?>
            <h1><?= $product->getName() ?></h1>
            <img src="<?= $product->getPhoto()[0] ?>" alt="">
            <p><?= $product->getPrice() ?></p>
            <p><?= $product->getDescription() ?></p>
            <p><?= $product->getQuantity() ?></p>
            <p><?= $product->getCreatedAt()->format('Y-m-d') ?></p>
            <p><?= $product->getUpdatedAt()->format('Y-m-d') ?></p>
            <p><?= $product->getIdCategory() ?></p>
            <?php if($product instanceof Clothing): ?>
                <p><?= $product->getSize() ?></p>
                <p><?= $product->getColor() ?></p>
                <p><?= $product->getType() ?></p>
                <p><?= $product->getMaterialFee() ?></p>
            <?php elseif($product instanceof Electronic): ?>
                <p><?= $product->getBrand() ?></p>
                <p><?= $product->getWarrantyFee() ?></p>
            <?php endif ?>
        <?php endif ?>
    </div>

    <div>
        <?php if(isset($_SESSION['user'])): ?>
            <form method="post">
                <input name="quantity" value="1">
                <input type="submit" value="Ajouter au panier">
            </form>
        <?php endif ?>
    </div>
</body>
</html>