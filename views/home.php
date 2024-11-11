<?php
if ($user->isAuthentified()) {
    $role = $user->getRole(); // Récupération du rôle de l'utilisateur
    echo "<h1>Welcome!</h1>";
    echo "<p>You are logged in as <strong>$role</strong>.</p>";
    echo "<p><a href='index.php?page=logout'>Logout</a></p>";

    // Affichage de liens spécifiques selon le rôle de l'utilisateur
    if (strtolower($role) === 'recruteur') {
        echo "<p><a href='index.php?page=offerForm'>Create an Offer</a></p>";
        echo "<p><a href='index.php?page=recruiterDashboard'>My Offers & Applications</a></p>";
        echo "<p><a href='index.php?page=requisOffreForm'>Add Requirements to an Offer</a></p>";
    } elseif (strtolower($role) === 'postulant') {
        echo "<p><a href='index.php?page=applicationForm'>Apply for an Offer</a></p>";

        $applications = $user->getUserApplicationsForProfile($_SESSION['user_id']);

        if (count($applications) > 0) {
            echo "<h2>Your Applications:</h2>";
            echo "<ul>";
            foreach ($applications as $application) {
                echo "<li>";
                echo "Job: " . htmlspecialchars($application['job_name']) . " - Salary: " . htmlspecialchars($application['salaire']);
                echo " <a href='index.php?page=profileForm&offer_id=" . $application['offer_id'] . "'>Fill Your Profile</a>";
                echo "</li>";
            }
            echo "</ul>";
            echo "<p><a href='index.php?page=candidateDashboard'>My Applications & Available Offers</a></p>";
        } else {
            echo "<p>You have not applied for any job yet.</p>";
        }

    }
} else {
    echo "<h1>Welcome to the Talent Management System</h1>";
    echo "<p>Please <a href='index.php?page=login'>login</a> or <a href='index.php?page=register'>register</a> to continue.</p>";
}
