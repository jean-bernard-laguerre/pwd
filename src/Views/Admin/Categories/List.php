<div>
    <?php
        foreach ($props['categories'] as $category) {
            echo '<div>';
            echo '<h1><a href="/pwd/admin/categories/show/' . $category->getId() . '">' . $category->getName() . '</a></h1>';
            echo '<p>' . $category->getDescription() . '</p>';
            echo '<form action="/pwd/admin/categories/delete/' . $category->getId() . '" method="post">';
            echo '<input type="submit" value="Delete">';
            echo '</form>';
            echo '</div>';
        }
    ?>
</div>