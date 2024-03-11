<div>
    <div>
        <h1><?php echo $props['product']->getName(); ?></h1>
        <p><?php echo $props['product']->getDescription(); ?></p>
        <form action="/pwd/admin/products/delete/<?php echo $props['product']->getId(); ?>" method="post">
            <input type="submit" value="Delete">
        </form>
    </div>
</div>