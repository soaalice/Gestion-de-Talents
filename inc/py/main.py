import sys
from extraction import extract_text_from_pdf

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Erreur : chemin du fichier non spécifié.")
        sys.exit(1)

    file_path = sys.argv[1]

    try:
        cv_text = extract_text_from_pdf(file_path)
        print(cv_text)
    except Exception as e:
        print(f"Erreur : {str(e)}")
        sys.exit(1)

<?php
// Vérifier si l'utilisateur est authentifié et est un postulant
if (!$user->isAuthentified() || strtolower($user->getRole()) !== 'client') {
    header('Location: index.php?page=login');
    exit;
}

$userId = $_SESSION['user_id']; // ID du postulant connecté

// Récupérer les offres disponibles
$offers = $user->getAvailableOffers($_SESSION['user_cv']);

// Récupérer les candidatures du postulant
$infos = $user->getCvDashboardInfoOffre($userId);
?>

<h2>Available Job Offers</h2>
<table border="1">
    <thead>
        <tr>
            <th>Offer ID</th>
            <th>Job Name</th>
            <th>Offer Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= htmlspecialchars($offer['offer_id']) ?></td>
                <td><?= htmlspecialchars($offer['job_name']) ?></td>
                <td><?= htmlspecialchars($offer['datecreation']) ?></td>
                <td>
                    <a href="index.php?page=detailOffre&&id=<?= htmlspecialchars($offer['offer_id']) ?>"><button>Voir plus</button>
                    </a>
                        <a href="index.php?page=applicationForm&id=<?= htmlspecialchars($offer['offer_id']) ?>"><button>Apply </button></a>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>My Applications</h2>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID Candidature</th>
            <th>Nom de la Personne</th>
            <th>Nom du Job</th>
            <th>Moyenne des Notes</th>
            <th>Date de Postulation</th>
            <th>État</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($infos as $info): ?>
            <tr>
                <td><?php echo htmlspecialchars($info['id_candidature']); ?></td>
                <td><?php echo htmlspecialchars($info['nom_personne']); ?></td>
                <td><?php echo htmlspecialchars($info['nom_job']); ?></td>
                <td><?php echo htmlspecialchars($info['moyenne_notes']); ?></td>
                <td><?php echo htmlspecialchars($info['datepostule']); ?></td>
                <td><?php echo $info['etat'] ? 'Acceptée' : 'En attente'; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>