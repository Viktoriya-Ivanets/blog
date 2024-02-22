<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <script src="assets/js/scripts.js" defer></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?mode=category">Categories</a></li>
                <?php if ($authInfo != null): ?>
                    <li><a href="add.php">Add article</a></li>
                    <li><a href="user_page.php?id=<?= $authInfo['id']; ?>">My page</a></li>
                    <li> <a href="notification.php">Notifications</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Signup</a></li>
                <?php endif; ?>
            </ul>
            <form method="post" action="search.php">
                Search:<input type="text" name="search">
                <button>Send</button>
            </form>
        </nav>
    </header>
    <?php if(isset($_SESSION['system_message'])): ?>
    <script>
        var SystemMessage = '<?php echo $_SESSION['system_message']; ?>';
        document.addEventListener("DOMContentLoaded", function() {
            addSystemMessage(SystemMessage);
        });
    </script>
    <?php unset($_SESSION['system_message']); ?>
<?php endif; ?>

    <main>
    <?= $content; ?>
    </main>

    <footer>
        <p>&copy; 2024 All rights reserved.</p>
    </footer>
</body>

</html>