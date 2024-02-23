<div>
    <?php
        foreach($props['users'] as $user) {
            echo '<div>';
            echo '<a href="/pwd/admin/users/show/' . $user->getId() . '">' . $user->getFullname() . '</a>';
            echo '<form action="/pwd/admin/users/delete/' . $user->getId() . '" method="post">';
            echo '<input type="submit" value="Delete">';
            echo '</form>';
            echo '</div>';
        }
    ?>
</div>