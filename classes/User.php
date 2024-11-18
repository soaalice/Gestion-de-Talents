<?php
header('Content-Type: text/html; charset=UTF-8');
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db->getConnection();
    }

    public function register($name, $email, $password, $phone, $dob, $roleId)
    {
        // Hashage du mot de passe avant la sauvegarde
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
        INSERT INTO Personne (nom, email, mdp, phone, datenaissance, idrole)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        return $stmt->execute([$name, $email, $hashedPassword, $phone, $dob, $roleId]);
    }


    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM Personne WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mdp'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
    }

    public function isAuthentified()
    {
        return isset($_SESSION['user_id']);
    }

    public function getRole()
    {
        if (!$this->isAuthentified())
            return null;

        $stmt = $this->db->prepare("SELECT r.nom FROM Role r JOIN Personne p ON r.id = p.idrole WHERE p.id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetchColumn();
    }

    public function getRoles()
    {
        $stmt = $this->db->prepare("SELECT id, nom FROM Role");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getJobs()
    {
        $stmt = $this->db->prepare("SELECT id, nom FROM Job");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getOffers()
    // {
    //     $stmt = $this->db->prepare("SELECT id, dateOffre, salaire FROM Offre");
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getOffers()
    {
        $stmt = $this->db->prepare("
        SELECT o.id, o.dateOffre, o.salaire, j.nom AS job_name 
        FROM Offre o
        LEFT JOIN Job j ON o.idjob = j.id
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecruiterOffers($recruiterId)
    {
        $stmt = $this->db->prepare("
        SELECT o.id AS offer_id, j.nom AS job_name, o.salaire, o.dateOffre
        FROM Offre o
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE o.idpersonne = ? and o.isTaken = false
    ");
        $stmt->execute([$recruiterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecruiterApplications($recruiterId)
    {
        $stmt = $this->db->prepare("
        SELECT c.id AS candidature_id, p.nom AS candidate_name, j.nom AS job_name, c.dateCandidature, c.isTaken AS isTaken, o.id as idoffre
        FROM Candidature c
        JOIN Personne p ON c.idpersonne = p.id
        JOIN Offre o ON c.idOffre = o.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE o.idpersonne = ? and o.isTaken = false
    ");
        $stmt->execute([$recruiterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableOffers()
    {
        $stmt = $this->db->prepare("
        SELECT o.id AS offer_id, j.nom AS job_name, o.salaire, o.dateOffre
        FROM Offre o
        LEFT JOIN Job j ON o.idjob = j.id where o.isTaken = false
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserApplications($userId)
    {
        $stmt = $this->db->prepare("
        SELECT c.id AS candidature_id, j.nom AS job_name, c.dateCandidature, o.id as idoffre
        FROM Candidature c
        JOIN Offre o ON c.idOffre = o.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE c.idpersonne = ? and o.isTaken = false
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserApplicationsForProfile($userId)
    {
        // Récupérer les offres pour lesquelles l'utilisateur a postulé
        $stmt = $this->db->prepare("
        SELECT o.id AS offer_id, j.nom AS job_name, o.salaire, o.dateOffre
        FROM Candidature c
        JOIN Offre o ON c.idOffre = o.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE c.idpersonne = ? and o.isTaken = false
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function createOffer($jobId, $salary, $dateOffer, $personId)
    {
        // Insertion d'une offre dans la base de données
        $stmt = $this->db->prepare("
        INSERT INTO Offre (idpersonne, idjob, dateoffre, salaire)
        VALUES (?, ?, ?, ?)
    ");
        return $stmt->execute([$personId, $jobId, $dateOffer, $salary]);
    }


    public function createApplication($offerId, $applicationDate, $personId)
    {
        // Insertion d'une candidature dans la base de données
        $stmt = $this->db->prepare("
        INSERT INTO Candidature (idpersonne, idoffre, datecandidature)
        VALUES (?, ?, ?)
    ");
        return $stmt->execute([$personId, $offerId, $applicationDate]);
    }

    public function getTypeChamps()
    {
        $stmt = $this->db->prepare("SELECT id, nom FROM TypeChamp");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer tous les requis avec leur type de champ
    public function getRequis()
    {
        $stmt = $this->db->prepare("SELECT r.id, r.nom, tc.nom AS type_name
                                FROM Requis r
                                LEFT JOIN TypeChamp tc ON r.idtypechamp = tc.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createRequisOffre($offerId, $requisId, $minimum, $maximum)
    {
        $stmt = $this->db->prepare("
        INSERT INTO RequisOffre (idoffre, idrequis, minimum, maximum)
        VALUES (?, ?, ?, ?)
    ");
        return $stmt->execute([$offerId, $requisId, $minimum, $maximum]);
    }

    // Récupérer les requis associés à une offre
    public function getRequisForOffer($offerId)
    {
        $stmt = $this->db->prepare("SELECT r.id, r.nom, tc.nom AS type_name
                                FROM Requis r
                                LEFT JOIN TypeChamp tc ON r.idtypechamp = tc.id
                                JOIN RequisOffre ro ON r.id = ro.idrequis
                                WHERE ro.idoffre = ?");
        $stmt->execute([$offerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insérer les données du profil dans la table Profile
    public function createProfile($userId, $requisId, $value)
    {
        $stmt = $this->db->prepare("
        INSERT INTO Profile (idpersonne, idrequis, valeur)
        VALUES (?, ?, ?)
        ON CONFLICT (idpersonne, idrequis) DO UPDATE SET valeur = ?
    ");
        try {
            return $stmt->execute([$userId, $requisId, $value, $value]);
        } catch (PDOException $e) {
            // Log error or display a message
            echo "Error: " . $e->getMessage();
        }
    }

    // Fonction pour récupérer la compatibilité d'une candidature
    public function getApplicationCompatibility($applicationId)
    {
        $stmt = $this->db->prepare("SELECT checkCompatibility(:applicationId) AS compatibility");
        $stmt->bindParam(':applicationId', $applicationId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['compatibility'];
    }

    // Fonction pour récupérer la note du test écrit
    public function getWrittenTestStatus($applicationId)
    {
        $stmt = $this->db->prepare("
            SELECT note FROM Evaluation 
            WHERE idcandidature = :applicationId AND idtype = 1
        ");
        $stmt->bindParam(':applicationId', $applicationId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction pour récupérer la note du test oral
    public function getOralTestStatus($applicationId)
    {
        $stmt = $this->db->prepare("
            SELECT note FROM Evaluation 
            WHERE idcandidature = :applicationId AND idtype = 2
        ");
        $stmt->bindParam(':applicationId', $applicationId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMinimumForTypeEvaluation($typeId)
    {
        $stmt = $this->db->prepare("
        SELECT minimum FROM type_evaluation WHERE id = ?
    ");
        $stmt->execute([$typeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['minimum'] : null;  // Si le type d'évaluation existe, retourne le minimum, sinon null
    }

    public function getMaximumForTypeEvaluation($typeId)
    {
        $stmt = $this->db->prepare("
        SELECT maximum FROM type_evaluation WHERE id = ?
    ");
        $stmt->execute([$typeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['maximum'] : null;  // Si le type d'évaluation existe, retourne le maximum, sinon null
    }

    public function getStyleForNote($typeId, $note)
    {
        // Récupérer les valeurs min et max pour le type d'évaluation donné
        $min = $this->getMinimumForTypeEvaluation($typeId);
        $max = $this->getMaximumForTypeEvaluation($typeId);

        // Vérifier si la note est dans les limites (min et max)
        if ($note < $min || $note > $max) {
            return 'color: red';  // Si la note est hors des limites, retourner "red"
        } else {
            return 'color: green';  // Si la note est dans les limites, retourner "green"
        }
    }


    // détalis

    public function getRequisOffre($idOffre)
    {
        $stmt = $this->db->prepare("
            SELECT r.nom, ro.minimum, ro.maximum
            FROM requisoffre ro
            JOIN requis r ON r.id = ro.idrequis
            WHERE ro.idoffre = ?
        ");
        $stmt->execute([$idOffre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOffreByJobId($idOffre)
    {
        $stmt = $this->db->prepare("
            SELECT j.nom, of.dateOffre, of.salaire
            FROM offre of
            JOIN job j ON j.id = of.idjob
            WHERE of.id = ?
        ");
        $stmt->execute([$idOffre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnreadNotifs($userId)  {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notifications WHERE idpersonne = :idpersonne AND etat=0 ");
        $stmt->bindParam(':idpersonne', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getNotifs($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE idpersonne = :idpersonne ORDER BY dateheure_at DESC");
        $stmt->bindParam(':idpersonne', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   
    }

    public function updateNotifs($notifId) {
        $stmt = $this->db->prepare("UPDATE notifications SET etat = 1 WHERE id = :id ");
        $stmt->bindParam(':id', $notifId, PDO::PARAM_INT);
        $stmt->execute();
    }

}   
