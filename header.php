<?php 
    header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="<?php echo $perso ?>">
    <title>Document</title>
</head>
<body style="background-color: #eaf4f0;"> <!-- Arrière-plan apaisant -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #107c41;"> <!-- Fond vert clair naturel -->
        <div class="container-fluid">
            <!-- Logo / Title -->
            <a class="navbar-brand" href="index.php" style="color: #d2f1d4; font-weight: bold;">Talent Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navbar links -->
                <ul class="navbar-nav ms-auto">
                    <?php $role = $user->getRole(); ?>
                    <?php if(isset($role) || !empty($role)) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php" style="color: #d2f1d4;">Role : <strong style='color: #d2f1d4;'><?php echo $role ?></strong></a>
                    </li>
                    <?php } ?>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php" style="color: #d2f1d4;">Home</a>
                    </li>
                    <?php if ($user->isAuthentified()): ?>
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
