<div>
    <div>
        <h1><?php echo $props['category']->getName(); ?></h1>
        <p><?php echo $props['category']->getDescription(); ?></p>
        <form action="/pwd/admin/categories/delete/<?php echo $props['category']->getId(); ?>" method="post">
            <input type="submit" value="Delete">
        </form>
    </div>
</div>