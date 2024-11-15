<?php
if ($user->isAuthentified()) {
    $role = $user->getRole(); // Récupération du rôle de l'utilisateur
    echo "<h1>Welcome!</h1>";
    echo "<p>You are logged in as <strong>$role</strong>.</p>";
    echo "<p><a href='index.php?page=logout'>Logout</a></p>";

    // Affichage de liens spécifiques selon le rôle de l'utilisateur
    if (strtolower($role) === 'admin') {
        echo "<p><a href='index.php?page=offerForm'>Create an Offer</a></p>";
        echo "<p><a href='index.php?page=recruiterDashboard'>My Offers & Applications</a></p>";
        echo "<p><a href='index.php?page=requisOffreForm'>Add Requirements to an Offer</a></p>";
    } elseif (strtolower($role) === 'client') {
        echo "<p><a href='index.php?page=applicationList'>Apply for an Offer</a></p>";
        echo "<p><a href='index.php?page=application'>Offer applied</a></p>";
        echo "<p><a href='index.php?page=creationCV'>My CV</a></p>";
    }
} else {
    echo "<h1>Welcome to the Talent Management System</h1>";
    echo "<p>Please <a href='index.php?page=login'>login</a> or <a href='index.php?page=register'>register</a> to continue.</p>";
}
