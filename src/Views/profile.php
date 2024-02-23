
        <h1><?= $props['profile']->getFullname() ?></h1>
        <p><?= $props['profile']->getEmail() ?></p>
        <p><?= $props['profile']->getRole()[0] ?></p>
        <form
            method="post"
        >
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $props['profile']->getFullname() ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $props['profile']->getEmail() ?>">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Update">
        </form>

