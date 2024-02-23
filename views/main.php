<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title; ?>
    </title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="assets/js/scripts.js" defer></script>
</head>

<body>
    <div class="container-fluid">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?mode=category">Categories</a>
                        </li>
                        <?php if ($authInfo != null): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="add.php">Add article</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="user_page.php?id=<?= $authInfo['id']; ?>">My page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notification.php">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Signup</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                            name="search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </header>
        <?php if (isset($_SESSION['system_message'])): ?>
            <script>
                var SystemMessage = '<?php echo $_SESSION['system_message']; ?>';
                document.addEventListener("DOMContentLoaded", function () {
                    addSystemMessage(SystemMessage);
                });
            </script>
            <?php unset($_SESSION['system_message']); ?>
        <?php endif; ?>
        <main>
            <div class="my-container">
                <?= $content; ?>
            </div>
        </main>
        <footer>
            <div class="my-container">
                <p>&copy; 2024 All rights reserved.</p>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
