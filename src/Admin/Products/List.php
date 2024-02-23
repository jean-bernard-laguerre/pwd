<div>
    <?php
        foreach ($props['products'] as $product) {
            echo '<div>';
            /* echo '<h1>' . $product->getName() . '</h1>'; */
            echo '<h1><a href="/pwd/admin/products/show/' . $product->getId() . '">' . $product->getName() . '</a></h1>';
            echo '<p>' . $product->getDescription() . '</p>';
            echo '<form action="/pwd/admin/products/delete/' . $product->getId() . '" method="post">';
            echo '<input type="submit" value="Delete">';
            echo '</form>';
            echo '</div>';
        }
    ?>
</div>