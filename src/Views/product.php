
    <?= $props['errorMessage'] ?>
    <div>
        <?php if(isset($props['product']) && ($props['product'])): ?>
            <h1><?= $props['product']->getName() ?></h1>
            <img src="<?= $props['product']->getPhoto()[0] ?>" alt="">
            <p><?= $props['product']->getPrice() ?></p>
            <p><?= $props['product']->getDescription() ?></p>
            <p><?= $props['product']->getQuantity() ?></p>
            <p><?= $props['product']->getCreatedAt()->format('Y-m-d') ?></p>
            <p><?= $props['product']->getUpdatedAt()->format('Y-m-d') ?></p>
            <p><?= $props['product']->getIdCategory() ?></p>
            <?php if($props['product'] instanceof App\Clothing): ?>
                <p><?= $props['product']->getSize() ?></p>
                <p><?= $props['product']->getColor() ?></p>
                <p><?= $props['product']->getType() ?></p>
                <p><?= $props['product']->getMaterialFee() ?></p>
            <?php elseif($props['product'] instanceof App\Electronic): ?>
                <p><?= $props['product']->getBrand() ?></p>
                <p><?= $props['product']->getWarrantyFee() ?></p>
            <?php endif ?>
        <?php endif ?>
    </div>

    <div>
        <?php if(isset($_SESSION['user']) && ($props['product'])): ?>
            <form method="post">
                <input name="quantity" value="1">
                <input type="submit" value="Ajouter au panier">
            </form>
        <?php endif ?>
    </div>
