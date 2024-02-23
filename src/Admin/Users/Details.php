<div>
    <?php
        echo '<div>';
        echo '<h1>' . $props['user']->getFullname() . '</h1>';
        echo '<p>' . $props['user']->getEmail() . '</p>';
        echo '<form action="/pwd/admin/users/delete/' . $props['user']->getId() . '" method="post">';
        echo '<input type="submit" value="Delete">';
        echo '</form>';
        echo '</div>';
    ?>
</div>