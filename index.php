<?php
require_once 'classes/Database.php';
require_once 'classes/User.php';

session_start();

// Initialisation de l'objet utilisateur
$db = new Database();
$user = new User($db);

// Gestion des routes
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$perso = "";
switch ($page) {
    case "notifications":
        $perso = "./assets/css/perso.css";
        break;
}
// Inclusion du header
include 'header.php';

// Inclusion de la vue correspondante
switch ($page) {
    case 'login':
        include 'views/login.php';
        break;
    case 'register':
        include 'views/register.php';
        break;
    case 'offerForm':
        include 'views/offerForm.php';
        break;
    case 'applicationForm':
        include 'views/applicationForm.php';
        break;
    case 'requisOffreForm':
        include 'views/requisOffreForm.php';
        break;
    case 'profileForm':
        include 'views/profileForm.php';
        break;
    case 'writtenTestForm':
        include 'views/writtenTestForm.php';
        break;
    case 'oralTestForm':
        include 'views/oralTestForm.php';
        break;
    case 'recruiterDashboard':
        include 'views/recruiterDashboard.php';
        break;
    case 'candidateDashboard':
        include 'views/candidateDashboard.php';
        break;
    case 'detailOffre':
        include 'views/offreDetails.php';
        break;
    case 'notifications':
        include 'views/notifications.php';
        break;
    case 'logout':
        $user->logout();
        header('Location: index.php');
        exit;
    default:
        include 'views/home.php';
        break;
}
include "footer.php";
