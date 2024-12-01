<?php
include "header.php";
$applications = $user->getUserApplications($_SESSION['user_id']);

?>
<div class="container ">
    <div class="mt-5 mb-5">

        <div class="title text-center py-2">
            <p class="display-6">Your Applications:</p>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-success text-white">
                <tr>
                    <th>Id</th>
                    <th>Recruteur</th>
                    <th>Job</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($applications)): ?>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                <?php endif; ?>
                <?php foreach ($applications as $offer): ?>
                    <tr>
                        <td><a
                                href="index.php?page=applicationForm&id=<?= $offer['id'] ?>"><?= htmlspecialchars($offer['id']) ?></a>
                        </td>
                        <td><?= htmlspecialchars($offer['demandeur']) ?></td>
                        <td><?= htmlspecialchars($offer['job_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href='index.php?page=candidateDashboard'>My Applications & Available Offers</a></p>
    </div>

</div>
<div class="row my-5">
    <div class="container my-5"></div>
</div>