<?php
include 'header.php';
$notification = $user->getNotifs($_SESSION['user_id']);
?>
<div class="container mt-5 mb-5">
    <?php foreach ($notification as $notif): ?>
        <div class="notification mb-3">
            <div class="row">
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="content-box bg-light-green p-4 pt-2 pb-2 rounded shadow-sm">
                        <p><?php echo $notif['textenotif'] ?></p>
                        <div class="col-12 text-start text-muted my-2">
                            <p class="timestamp"><?php echo $notif['dateheure_at'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row text-end ">
                <p class="p-2">Lue</p>
            </div> -->
        </div>
    <?php 
    if ($notif['etat'] != 1) {
        $user -> updateNotifs($notif['id']);
    }
    endforeach; 
    ?>

</div>