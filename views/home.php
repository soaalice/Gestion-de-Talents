<?php
if ($user->isAuthentified()) {
    $role = $user->getRole();
    echo "<div class='container mt-5 mb-5'>";
    echo "<div class='card shadow-lg p-4 mb-5' style='background-color: #f1f8f3;'>";
    echo "<h1 class='display-2 text-center mt-5 mb-5 welcome-animation' style='color: #3a6a40;'>Welcome!</h1>";

    // Affichage de liens spécifiques selon le rôle de l'utilisateur
    if (strtolower($role) === 'recruteur') {
        echo "<div class='row mt-5'>";
        echo "<div class='col-4'><p class='text-center'><a href='index.php?page=offerForm' class='btn btn-warning btn-lg highlight-btn'>Create an Offer</a></p></div>";
        echo "<div class='col-4'><p class='text-center'><a href='index.php?page=recruiterDashboard' class='btn btn-success btn-lg highlight-btn'>My Offers & Applications</a></p></div>";
        echo "<div class='col-4'><p class='text-center'><a href='index.php?page=requisOffreForm' class='btn btn-warning btn-lg highlight-btn'>Add Requirements to an Offer</a></p></div>";
        echo "</div>";
    } elseif (strtolower($role) === 'postulant') {
        echo "<p class='text-center'><a href='index.php?page=applicationForm' class='btn btn-outline-warning btn-lg highlight-btn'>Apply for an Offer</a></p>";

        $applications = $user->getUserApplicationsForProfile($_SESSION['user_id']);

        if (count($applications) > 0) {
            echo "<p class='text-center mt-3'><a href='index.php?page=candidateDashboard' class='btn btn-outline-success btn-lg highlight-btn'>My Applications & Available Offers</a></p>";
            echo "<h3 class='mt-4' style='color: #3a6a40;'>Your Applications:</h3>";
            echo "<ul class='list-group mt-3'>";
            foreach ($applications as $application) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center application-item'>";
                echo "<div class='job-info'>Job: " . htmlspecialchars($application['job_name']) . " - Salary: " . htmlspecialchars($application['salaire']) . "</div>";
                echo "<a href='index.php?page=profileForm&offer_id=" . $application['offer_id'] . "' class='btn btn-success text-decoration-none profile-btn'>Fill Your Profile</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='text-center'>You have not applied for any job yet.</p>";
        }
    }
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='container mt-5 mb-5'>";
    echo "<div class='card shadow-lg p-4' style='background-color: #f1f8f3;'>";
    echo "<h1 class='display-4 text-center typewriter-animation p-3' style='color: #3a6a40;'>Welcome to the Talent Management System</h1>";
    echo "<p class='lead text-center' style='color: #6d9e4e;'>Please</p>";
    echo "<div class='d-flex justify-content-center'>";
    echo "<a href='index.php?page=login' class='btn btn-warning btn-lg mx-2 highlight-btn'>Log in</a>";
    echo "<a href='index.php?page=register' class='btn btn-success btn-lg mx-2 highlight-btn'>Register</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>

<!-- CSS pour l'animation et le style -->
<style>
    /* Animation pour le titre "Welcome!" */
    @keyframes fade-in-scale {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .welcome-animation {
        animation: fade-in-scale 1s ease-out;
    }

    /* Animation de style machine à écrire pour le texte */
    .typewriter-animation {
        overflow: hidden;
        white-space: nowrap;
        border-right: 0.15em solid #3a6a40;
        animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
    }

    @keyframes typing {
        from { width: 0; }
        to { width: 100%; }
    }

    @keyframes blink-caret {
        50% { border-color: transparent; }
    }

    .highlight-btn {
        transition: all 0.3s ease-in-out;
    }
    .highlight-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(56, 189, 94, 0.5);
    }

    /* Style spécifique pour les candidatures des postulants */
    .application-item {
        background-color: #eaf4f0;
        border-color: #d0e0d6;
        padding: 1rem;
        transition: background-color 0.3s ease;
    }
    .application-item:hover {
        background-color: #d0e0d6;
    }

    .job-info {
        font-weight: bold;
        color: #3a6a40;
    }

    .profile-btn {
        background-color: #3a6a40;
        color: #ffffff;
    }
    .profile-btn:hover {
        background-color: #2b7a2b;
    }
</style>
