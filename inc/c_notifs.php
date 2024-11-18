<?php
require_once('../classes/Database.php');
$db = new Database();

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo json_encode(['unreadCount'=>0]);
    exit;
}
$userId = (int) $_GET['user_id'];

$con = $db->getConnection();
$stmt = $con->prepare("SELECT COUNT(*) FROM notifications WHERE idpersonne = :idpersonne AND etat = 0");
$stmt->bindParam(':idpersonne', $userId, PDO::PARAM_INT);
$stmt->execute();
$unreadCount = $stmt->fetchColumn();

echo json_encode(['unreadCount' => $unreadCount]);