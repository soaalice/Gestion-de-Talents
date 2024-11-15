<?php
$offers = $user->getOffers();
?>
<h2>List Applications:</h2>
<table border="1">
    <tr>
        <td>Id</td>
        <td>Recruteur</td>
        <td>Job</td>
    </tr>
    <?php foreach ($offers as $offer): ?>
    <tr>
        <td><a href="index.php?page=applicationForm&id=<?=$offer['id'] ?>"><?= htmlspecialchars($offer['id']) ?></a></td>
        <td><?= htmlspecialchars($offer['demandeur']) ?></td>
        <td><?= htmlspecialchars($offer['job_name']) ?></td>
        </tr>
        <?php endforeach; ?>
</table>