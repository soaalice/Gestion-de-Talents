<?php
require 'classes/Constante.php';
header('Content-Type: text/html; charset=UTF-8');
class User
{
    private $db;
    private $cons;

    public function __construct($db)
    {
        $this->db = $db->getConnection();
    }

    public function register($name, $email, $password, $phone, $dob)
    {
        // Hashage du mot de passe avant la sauvegarde
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
        INSERT INTO Personne (nom, email, mdp, phone, datenaissance, idrole)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        return $stmt->execute([$name, $email, $hashedPassword, $phone, $dob, 2]);
    }

    public function register2($name, $email, $password, $phone, $dob,$idRole)
    {
        // Hashage du mot de passe avant la sauvegarde
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
        INSERT INTO Personne (nom, email, mdp, phone, datenaissance, idrole)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
        return $stmt->execute([$name, $email, $hashedPassword, $phone, $dob, $idRole]);
    }
    public function getPersonById($id){
        $stmt = $this->db->prepare("select * from Personne WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT p.id, p.nom , p.email , p.phone , p.datenaissance , p.idrole , p.mdp  , cv.id as idcv
        FROM Personne p
        left join cv on cv.idpersonne = p.id
         WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mdp'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_cv'] = $user['idcv'];
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
        SELECT o.id, o.dateCreation,o.dateFin, o.exigence, j.nom AS job_name, p.nom as demandeur 
        FROM Offre o
        LEFT JOIN Job j ON o.idjob = j.id
        LEFT JOIN Personne p ON o.idPersonne = p.id
        where o.id not in (select ca.idoffre
        from contrat c
        left join candidature ca 
        on c.candidature_id = ca.id
        where c.statut_id = ?
    )");
        $stmt->execute([Constante::id_actif()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOfferById($id)
    {
        $stmt = $this->db->prepare("
       select * from offre
       where id =  ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecruiterOffers($recruiterId)
    {
        $stmt = $this->db->prepare("
        SELECT o.id AS offer_id, j.nom AS job_name, o.dateCreation
        FROM Offre o
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE o.idpersonne = ? 
    ");
        $stmt->execute([$recruiterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecruiterApplications($recruiterId)
    {
        $stmt = $this->db->prepare("
        SELECT c.id AS candidature_id, p.nom AS candidate_name, j.nom AS job_name, c.datePostule, o.id as idoffre
        FROM Candidature c
        JOIN cv ON cv.id = c.idcv
        JOIN Personne p ON cv.idpersonne = p.id
        JOIN Offre o ON c.idOffre = o.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE o.idpersonne = ? 
    ");
        $stmt->execute([$recruiterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableOffers()
    {
        $stmt = $this->db->prepare("
        SELECT o.id AS offer_id, j.nom AS job_name, o.dateCreation,o.dateFin
        FROM Offre o
        LEFT JOIN Job j ON o.idjob = j.id 
        where o.id not in (select ca.idoffre
        from contrat c
        left join candidature ca 
        on c.candidature_id = ca.id
        where c.statut_id = ?)
    ");
        $stmt->execute([Constante::id_actif()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserApplications($userId)
    {
        $stmt = $this->db->prepare("
        SELECT  o.id, o.dateCreation,o.dateFin, o.exigence, j.nom AS job_name, p.nom as demandeur 
        FROM Offre o
        Left join Personne p on o.idPersonne = p.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE o.id in (select idOffre 
        from candidature c 
        Left join cv on cv.id = c.idcv
        WHERE cv.idpersonne = ?) 
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserApplicationsForProfile($userId)
    {
        // Récupérer les offres pour lesquelles l'utilisateur a postulé
        $stmt = $this->db->prepare("
        SELECT o.id AS offer_id, j.nom AS job_name, o.datecreation
        FROM Candidature c
        JOIN Cv on c.idcv = Cv.id
        JOIN Offre o ON c.idOffre = o.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE cv.idpersonne = ?
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isApplying($userId,$offreid)
    {
        $stmt = $this->db->prepare("
        SELECT  o.id, o.dateCreation,o.dateFin, o.exigence, j.nom AS job_name, p.nom as demandeur 
        FROM Offre o
        Left join Personne p on o.idPersonne = p.id
        LEFT JOIN Job j ON o.idjob = j.id
        WHERE o.id in (select idOffre 
        from candidature c 
        Left join cv on cv.id = c.idcv
        WHERE cv.idpersonne = ?) and 
        o.id = ?
    ");
        $stmt->execute([$userId,$offreid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createOffer($jobId, $exigence,$datelimit, $dateOffer, $personId)
    {
        // Insertion d'une offre dans la base de données
        $stmt = $this->db->prepare("
        INSERT INTO Offre (idpersonne, idjob, dateCreation, dateFin, exigence)
        VALUES (?, ?, ?, ?, ?)
    ");
        return $stmt->execute([$personId, $jobId, $dateOffer,$datelimit, $exigence]);
    }


    public function createApplication($offerId, $applicationDate, $cvId)
    {
        // Insertion d'une candidature dans la base de données
        $stmt = $this->db->prepare("
      INSERT INTO Candidature (idcv, idOffre, datePostule, etat)
        VALUES (?, ?, ?,?)
    ");
        return $stmt->execute([$cvId, $offerId, $applicationDate,'FALSE']);
    }


    public function createORreplaceCV($com, $exp, $ed,$id,$cv){
        if(isset($cv) || !empty($cv)){
            $stmt = $this->db->prepare("
            UPDATE cv set competence = ? , experience = ? , education = ?
            where idpersonne = ?
            ");
            return $stmt->execute([ $com, $exp,$ed,$id]);
        }else{
            $stmt = $this->db->prepare("
            INSERT INTO cv (idpersonne, competence, experience, education)
            VALUES (?, ?, ?,?)
            ");
            return $stmt->execute([$id, $com, $exp,$ed]);
        }
    } 

    public function getCVbyId($id) {
        $stmt = $this->db->prepare("
        SELECT * FROM cv 
        WHERE idpersonne = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            WHERE idcandidature = :applicationId AND idtypeevaluation = 1
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
            WHERE idcandidature = :applicationId AND idtypeevaluation = 2
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


    public function getOffreById($idOffre)
    {
        $stmt = $this->db->prepare("
            SELECT of.id, of.dateCreation,of.dateFin, of.exigence, j.nom AS job_name, p.nom as demandeur 
            FROM offre of
            JOIN job j ON j.id = of.idjob
            JOIN Personne p ON p.id = of.idPersonne
            WHERE of.id = ?
        ");
        $stmt->execute([$idOffre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonneIdByCandidatureId($idCandidature)
    {
        $query = "SELECT idpersonne FROM Candidature WHERE id = :idCandidature";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idCandidature', $idCandidature, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();  // Renvoie l'ID de la personne
    }


    // Modif Fanah

    public function getExigenceByOffre($idOffre)
    {
        // Préparer la requête SQL
        $stmt = $this->db->prepare("
            SELECT exigence
            FROM Offre
            WHERE id = :id_offre
        ");

        // Exécuter la requête avec le paramètre
        $stmt->execute([':id_offre' => $idOffre]);

        // Récupérer le résultat
        return $stmt->fetchColumn();
    }

    public function saveCV($idPersonne, $education, $noteEducation, $experience, $noteExperience, $competence, $noteCompetence, $remarque, $chemin)
    {
        echo "début save";
        // Préparer la requête d'insertion
        $stmt = $this->db->prepare("
            INSERT INTO cv (idpersonne, education, note_education, experience, note_experience, competence, note_competence, remarque, chemin)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        // Exécuter la requête avec les données
        if ($stmt->execute([
            $idPersonne,
            $education,
            $noteEducation,
            $experience,
            $noteExperience,
            $competence,
            $noteCompetence,
            $remarque,
            $chemin
        ])) {
            // Retourner l'identifiant du dernier CV inséré
            // echo "fin save. Done!";
            return $this->db->lastInsertId();
        }
        echo "Echec";
        // En cas d'échec, retourner false
        return false;
    }


    public function getCvDashboardInfoPerson($idperson)
    {

        $stmt = $this->db->prepare("
            SELECT 
                id_candidature,
                nom_personne,
                id_offre,
                nom_job,
                note_competence,
                note_experience,
                note_education,
                moyenne_notes,
                datePostule,
                etat
            FROM 
                v_cv_dashboard
            WHERE 
                id_personne = ?
            order by datePostule desc    
        ");

        $stmt->execute([$idperson]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCvDashboardInfoOffre($offre)
    {

        $stmt = $this->db->prepare("
            SELECT 
                id_candidature,
                nom_personne,
                nom_job,
                note_competence,
                note_experience,
                note_education,
                moyenne_notes,
                datePostule,
                etat
            FROM 
                v_cv_dashboard
            WHERE 
                id_offre = ?
        ");

        $stmt->execute([$offre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCvById2($id)
    {
        // Préparer la requête pour récupérer les informations du CV par ID
        $stmt = $this->db->prepare("
            SELECT 
                id,
                idpersonne,
                competence,
                note_competence,
                experience,
                note_experience,
                education,
                note_education,
                remarque,
                chemin
            FROM 
                cv
            WHERE 
                id = ?
        ");

        // Exécuter la requête avec l'ID donné
        $stmt->execute([$id]);

        // Retourner le résultat sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getCvDashboardInfoOffreRecruter($idrecruteur)
    {

        $stmt = $this->db->prepare("
            SELECT 
                id_candidature,
                id_personne,
                id_recruteur,
                nom_personne,
                nom_job,
                id_offre,
                note_competence,
                note_experience,
                note_education,
                moyenne_notes,
                datePostule,
                etat
            FROM 
                v_cv_dashboard
            WHERE 
                id_recruteur = ? 
        ");

        $stmt->execute([$idrecruteur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function checkExistence($idcandidature){
        $stmt = $this->db->prepare("
        SELECT 
          *
        FROM 
            contrat
        WHERE 
            candidature_id = ?
    ");

    $stmt->execute([$idcandidature]);
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

    public function insertNotifs($text, $iddestinataire)  {
        $stmt = $this->db->prepare("INSERT INTO notifications (textenotif, idpersonne) VALUES ( :texte , :idpersonne )");
        $stmt->bindParam(':texte', $text, PDO::PARAM_STR);
        $stmt->bindParam(':idpersonne', $iddestinataire, PDO::PARAM_INT);
      return  $stmt->execute();
    }
    public function getNiveauByCandidature($candidature_id) {
    // Définir la requête SQL pour obtenir le niveau via l'ID de la candidature
        $query = "
            SELECT j.niveau 
            FROM Candidature c
            JOIN Offre o ON c.idOffre = o.id
            JOIN Job j ON o.idjob = j.id
            WHERE c.id = :candidature_id
        ";

        // Préparer la requête
        $stmt = $this->db->prepare($query);

        // Lier le paramètre
        $stmt->bindParam(':candidature_id', $candidature_id, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourner le niveau si trouvé, sinon retourner NULL
        return $result ? $result['niveau'] : null;
    }

    public function createContract($date_debut,$date_fin,$salaire,$candidature,$employe_id,$employeur_id){
        $query = "INSERT INTO Contrat (date_debut, date_fin,salaire, statut_id,candidature_id, employe_id, employeur_id, niveau) 
        VALUES (:date_debut, :date_fin,:salaire, :statut_id,:candidature, :employe_id, :employeur_id, :niveau)";
        $statut = Constante::id_actif();
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date_debut', $date_debut);
        $stmt->bindParam(':date_fin', $date_fin);
        $stmt->bindParam(':salaire', $salaire);
        $stmt->bindParam(':statut_id',$statut);
        $stmt->bindParam(':candidature',$candidature);
        $stmt->bindParam(':employe_id', $employe_id);
        $stmt->bindParam(':employeur_id', $employeur_id);
        $stmt->bindParam(':niveau', $this->getNiveauByCandidature($candidature));
        $this->insertNotifs("Vous avez un nouveau contrat.",$employe_id);
       return $stmt->execute();
    }

    public function getMyContract($user){
        $stmt = $this->db->prepare("
           Select employe_id as id,date_debut,date_fin,salaire,p.nom from contrat c
           left join personne p
           on p.id = c.employeur_id
           where employe_id = ?
           and statut_id = ?
        ");

        $stmt->execute([$user,Constante::id_actif()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createRupture($date,$idcontract,$type){
         $stmt = $this->db->prepare("
         INSERT INTO rupturecontrat (contrat_id, date_rupture, type_rupture_id)
         VALUES (?, ?, ?)
     ");
     $stmt->execute([$idcontract, $date, $type]);
         return  $this->db->lastInsertId(); 
    }
    public function resilieContract($idcontract){
        $stmt = $this->db->prepare("
        update contrat set statut_id = ? where id = ?
    ");
        return $stmt->execute([Constante::id_resilie(), $idcontract]);
    }
    public function createPreavis($rupture_id,$date){
        $stmt = $this->db->prepare("
        INSERT INTO preavis (rupture_id, date_debut, date_fin,statut_preavis_id)
        VALUES (?, ?, ?, ?)
    ");
        return $stmt->execute([$rupture_id, $date, Constante::date_fin($date),Constante::id_en_cours()]);
    }

    public function ruptureContract($user,$idcontract,$employeur,$type){    
        $date =date("Y-m-d");
       $rupture_id =  $this->createRupture($date,$idcontract,$type);
       $this->resilieContract($idcontract);
       $this->createPreavis($rupture_id,$date);
        $text = "";
        $idreceiver=$user;
        if ($type == Constante::id_demission()) {
            $person = $this->getPersonById($user);
            $text = "L'employe ".$person[0]['nom']." a pose une lettre de demision.";
            $this->insertNotifs("Vous venez de resilier votre contrat , il vous reste 1 mois.",$user);
            $idreceiver=$employeur;
        } else {
            $person = $this->getPersonById($employeur);
            $text = "L'employeur ".$person[0]['nom']." a decide de vous licencier , votre contrat a donc ete resilie. Il vous reste 1 mois.";
            $idreceiver=$user;
        }
       return $this->insertNotifs($text,$idreceiver);
    }

    public function getEmployes($id){
        $stmt = $this->db->prepare("
        Select p.nom,c.id,c.employe_id,c.niveau from contrat c
        left join personne p
        on p.id = c.employe_id
        where c.employeur_id = ?
        and statut_id = ?
     ");

     $stmt->execute([$id,Constante::id_actif()]);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEmployesPreavis($id){
        $stmt = $this->db->prepare("
        Select p.nom,pr.id as preavis_id,c.employe_id,c.salaire
         from  preavis pr
        left join ruptureContrat r
        on pr.rupture_id = r.id
        left join contrat c
        on c.id = r.contrat_id
        left join personne p
        on p.id = c.employe_id
        where c.employeur_id = ?
        and c.statut_id = ?
        and pr.statut_preavis_id = ?
        
     ");

     $stmt->execute([$id,Constante::id_resilie(),Constante::id_en_cours()]);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEmployesPreavisIndemnite($id){
        $stmt = $this->db->prepare("
         Select p.nom,pr.id as preavis_id,c.employe_id
         from IndemnitePreavis ip
         left join preavis pr
         on pr.id = ip.preavis_id
        left join ruptureContrat r
        on pr.rupture_id = r.id
        left join contrat c
        on c.id = r.contrat_id
        left join personne p
        on p.id = c.employe_id
        where c.employeur_id = ?
        and c.statut_id = ?
        and pr.statut_preavis_id = ?
        and ip.statut_paiement_id = ?
        
     ");

     $stmt->execute([$id,Constante::id_resilie(),Constante::id_non_respecter(),Constante::id_en_attente()]);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePreavis($preavis_id,$statut){
        $stmt = $this->db->prepare("
        UPDATE Preavis
        SET statut_preavis_id = ?
        WHERE id = ?
    ");
        return $stmt->execute([$statut, $preavis_id]);
    }

    public function createIndemnite($preavis_id,$statut,$salaire,$emp){
        $this->updatePreavis($preavis_id,Constante::id_non_respecter());
        $stmt = $this->db->prepare("
        INSERT INTO IndemnitePreavis (preavis_id, montant, date_paiement, statut_paiement_id)
VALUES (?, ?, NULL, ?); 
    ");
    $this->insertNotifs("Vous n'avez pas respecte le preavis , veuillez payer l'indemnite qui s'eleve a ".$salaire." MGA",$emp);
    return $stmt->execute([$preavis_id, $salaire,Constante::id_en_attente()]);
}
    public function updateIndemnite($id,$date,$idemp){
        $stmt = $this->db->prepare("
        UPDATE IndemnitePreavis
        SET date_paiement = ?,
        statut_paiement_id = ? 
        WHERE id = ?
        ");
        $this->insertNotifs("L'indemnite a ete paye en totalite le ".$date.".",$idemp);
        return $stmt->execute([$date, Constante::id_regle(),$id]);
    }
    public function getIndemnite($id){
        $stmt = $this->db->prepare("
          Select ip.montant,ip.id,c.employeur_id
         from IndemnitePreavis ip
         left join preavis pr
         on pr.id = ip.preavis_id
        left join ruptureContrat r
        on pr.rupture_id = r.id
        left join contrat c
        on c.id = r.contrat_id
        where c.employe_id = ?
        and c.statut_id = ?
        and pr.statut_preavis_id = ?
        and ip.statut_paiement_id = ?
     ");

     $stmt->execute([$id,Constante::id_resilie(),Constante::id_non_respecter(),Constante::id_en_attente()]);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // heure supp 

    public function getHeuresSupParSemaine($mois, $employe_id) {
        $stmt = $this->db->prepare("
            SELECT 
                DATE_TRUNC('week', date) AS semaine_debut,
                employe_id,
                SUM(heures_travail) AS total_heures
            FROM 
                HeuresSupplementaires
            WHERE 
                DATE_TRUNC('month', date) = DATE_TRUNC('month', ?::DATE)
                AND employe_id = ?
            GROUP BY 
                DATE_TRUNC('week', date), employe_id
            ORDER BY 
                semaine_debut
        ");
        $stmt->execute([$mois . '-01', $employe_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getHeuresSpecialesParMois($mois, $employe_id) {
        $stmt = $this->db->prepare("
            SELECT 
                tj.type_label AS type_jour,
                COALESCE(SUM(hs.heures_travail), 0) AS total_heures
            FROM 
                TypesJours tj
            LEFT JOIN 
                HeuresSpeciales hs 
                ON hs.type_jour_id = tj.id
                AND hs.employe_id = ?
                AND DATE_TRUNC('month', hs.date) = DATE_TRUNC('month', ?::DATE)
            GROUP BY 
                tj.type_label
            ORDER BY 
                tj.type_label;
        ");
        $stmt->execute([$employe_id, $mois . '-01']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getEmployeInfo($employe_id) {
        $stmt = $this->db->prepare("
            SELECT 
                p.id AS id,
                p.nom AS nom,
                j.nom AS job,
                p.datenaissance AS date_naissance,
                p.email,
                p.phone,
                c.date_debut AS dt_embauche,
                DATE_PART('year', AGE(c.date_debut)) || ' ans' AS anciennete,
                c.salaire
            FROM 
                Personne p
            JOIN 
                Contrat c ON p.id = c.employe_id
            JOIN 
                Job j ON j.id = c.candidature_id
            WHERE 
                p.id = ?
        ");
        $stmt->execute([$employe_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    
}   