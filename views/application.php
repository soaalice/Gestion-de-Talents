<?php

$applications = $user->getUserApplications($_SESSION['user_id']);

?>  
<h2>Your Applications:</h2>
<table border="1">
    <tr>
        <td>Id</td>
        <td>Recruteur</td>
        <td>Job</td>
    </tr>
    <?php foreach ($applications as $offer): ?>
    <tr>
        <td><a href="index.php?page=applicationForm&id=<?=$offer['id'] ?>"><?= htmlspecialchars($offer['id']) ?></a></td>
        <td><?= htmlspecialchars($offer['demandeur']) ?></td>
        <td><?= htmlspecialchars($offer['job_name']) ?></td>
        </tr>
        <?php endforeach; ?>
</table>

<p><a href='index.php?page=candidateDashboard'>My Applications & Available Offers</a></p>;