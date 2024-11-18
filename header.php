<?php
header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="<?php echo $perso ?>">
    
    <title>Gestion des Talents</title>
</head>

<body style="background-color: #eaf4f0;" class="vh-100"> <!-- Arrière-plan apaisant -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #107c41;">
        <!-- Fond vert clair naturel -->
        <div class="container-fluid">
            <!-- Logo / Title -->
            <a class="navbar-brand" href="index.php" style="color: #d2f1d4; font-weight: bold;">Talent Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navbar links -->
                <ul class="navbar-nav ms-auto">
                    <?php $role = $user->getRole(); ?>
                    <?php if (isset($role) || !empty($role)) { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php" style="color: #d2f1d4;">Role : <strong
                                    style='color: #ffffff;'><?php echo $role ?></strong></a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link active" href="index.php" style="color: #d2f1d4;">Home</a>
                    </li>
                    <?php if ($user->isAuthentified()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=notifications">
                                <i class="fas fa-bell"></i>
                                <span id="notificationBadge" class="badge rounded-pill bg-danger"> 0 </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=logout" style="color: #d2f1d4;">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=login" style="color: #d2f1d4;">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=register" style="color: #d2f1d4;">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<?php
if ($user->isAuthentified()) :
    if ($role == 'Postulant') {
        include('views/chat.php');
    }
?>

<script>
    function checkNotifs() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'inc/c_notifs.php?user_id=<?php echo $_SESSION['user_id'] ?>' , true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response);
                var unreadCount = response.unreadCount;

                var notificationBadge =document.getElementById('notificationBadge');
                if (unreadCount >0) {
                    notificationBadge.innerText =unreadCount;
                }
            }
        };
        xhr.send();
    }
    setInterval(checkNotifs, 1000);
    checkNotifs();
</script>

<?php endif ?>