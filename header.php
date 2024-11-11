<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if ($user->isAuthentified()): ?>
            <li><a href="index.php?page=logout">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php?page=login">Login</a></li>
            <li><a href="index.php?page=register">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>