<?php
$notification = [
    [
        "id" => 1,
        "texteNotif" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam a labore velit unde adipisci nobis soluta numquam nemo maiores aperiam tempora, magni est possimus consectetur vero quae. Autem, iusto explicabo!",
        "idPersonne" => "PER000001",
        "etat" => "non lue",
        "dateHeure" => "Monday Nov 12 . 4:39"
    ]
    ,
    [
        "id" => 1,
        "texteNotif" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam a labore velit unde adipisci nobis soluta numquam nemo maiores aperiam tempora, magni est possimus consectetur vero quae. Autem, iusto explicabo!",
        "idPersonne" => "PER000001",
        "etat" => "non lue",
        "dateHeure" => "Monday Nov 12 . 4:39"
    ]
    ,
    [
        "id" => 1,
        "texteNotif" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam a labore velit unde adipisci nobis soluta numquam nemo maiores aperiam tempora, magni est possimus consectetur vero quae. Autem, iusto explicabo!",
        "idPersonne" => "PER000001",
        "etat" => "non lue",
        "dateHeure" => "Monday Nov 12 . 4:39"
    ]
    ,
    [
        "id" => 1,
        "texteNotif" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam a labore velit unde adipisci nobis soluta numquam nemo maiores aperiam tempora, magni est possimus consectetur vero quae. Autem, iusto explicabo!",
        "idPersonne" => "PER000001",
        "etat" => "non lue",
        "dateHeure" => "Monday Nov 12 . 4:39"
    ]
    ,
    [
        "id" => 1,
        "texteNotif" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam a labore velit unde adipisci nobis soluta numquam nemo maiores aperiam tempora, magni est possimus consectetur vero quae. Autem, iusto explicabo!",
        "idPersonne" => "PER000001",
        "etat" => "non lue",
        "dateHeure" => "Monday Nov 12 . 4:39"
    ]
];
$index = 1;
?>
<div class="container mt-5 mb-5">
    <?php foreach ($notification as $notif): ?>
        <div class="notification mb-3">
            <div class="row">
                <!-- <div class="col-12 text-center text-muted">
                    <p class="timestamp"><?php echo $notif['dateHeure'] ?></p>
                </div> -->
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <div class="row">
                        <div
                            class="col-12 bg-badge-green rounded-circle text-white d-flex justify-content-center align-items-center badge-icon">
                            <p><?php echo $index ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-11">
                    <div class="content-box bg-light-green p-4 pt-2 pb-2 rounded shadow-sm">
                        <p><?php echo $notif['texteNotif'] ?></p>
                        <div class="col-12 text-start text-muted my-2">
                            <p class="timestamp"><?php echo $notif['dateHeure'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row text-end ">
                <p class="p-2">Lue</p>
            </div> -->
        </div>
        <?php $index++; ?>
    <?php endforeach; ?>

</div>