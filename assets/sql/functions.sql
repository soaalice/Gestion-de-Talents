-- CREATE OR REPLACE FUNCTION checkCompatibility(idcandidature INT)
-- RETURNS INT AS $$
-- DECLARE
--     v_idpersonne INT;
--     v_idoffre INT;
--     v_requis_id INT;
--     v_valeur_profil VARCHAR(255);
--     v_minimum VARCHAR(255);
--     v_maximum VARCHAR(255);
--     v_compatibilite INT := 2;  -- Par défaut, on considère compatible
-- BEGIN
--     -- Récupération de la personne et de l'offre à partir de la candidature
--     SELECT c.idpersonne, c.idOffre
--     INTO v_idpersonne, v_idoffre
--     FROM Candidature c
--     WHERE c.id = idcandidature;

--     -- Si la candidature n'existe pas, on retourne incompatible (1)
--     IF v_idpersonne IS NULL OR v_idoffre IS NULL THEN
--         RETURN 1;
--     END IF;

--     -- Pour chaque exigence de l'offre
--     FOR v_requis_id IN
--         SELECT ro.idrequis
--         FROM RequisOffre ro
--         WHERE ro.idoffre = v_idoffre
--     LOOP
--         -- Récupération de la valeur exigée pour cette exigence (minimum et maximum)
--         SELECT ro.minimum, ro.maximum
--         INTO v_minimum, v_maximum
--         FROM RequisOffre ro
--         WHERE ro.idrequis = v_requis_id AND ro.idoffre = v_idoffre;

--         -- Récupération de la valeur du profil de la personne
--         SELECT p.valeur
--         INTO v_valeur_profil
--         FROM Profile p
--         WHERE p.idpersonne = v_idpersonne AND p.idrequis = v_requis_id;

--         -- Si la personne n'a pas renseigné de valeur pour cette exigence, elle est incompatible
--         IF v_valeur_profil IS NULL THEN
--             v_compatibilite := 1;
--             EXIT;  -- Si déjà incompatible, pas besoin de continuer
--         END IF;

--         -- Comparaison des exigences avec le profil
--         IF v_minimum IS NOT NULL AND v_valeur_profil < v_minimum THEN
--             v_compatibilite := 1;  -- La valeur est inférieure au minimum requis
--             EXIT;  -- Si incompatible, on arrête la vérification
--         ELSIF v_maximum IS NOT NULL AND v_valeur_profil > v_maximum THEN
--             v_compatibilite := 3;  -- La valeur dépasse le maximum requis (surcompatible)
--         END IF;
--     END LOOP;

--     RETURN v_compatibilite;
-- END;
-- $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION checkCompatibility(idcandidature INT)
RETURNS INT AS $$
DECLARE
    v_compatible BOOLEAN := TRUE;
    v_surcompatible BOOLEAN := TRUE;
    v_requis RECORD;
    v_profile RECORD;
    v_requisOffre RECORD;
BEGIN
    -- Vérification des requis de l'offre liée à la candidature
    FOR v_requis IN
        SELECT r.id, r.nom, ro.minimum, ro.maximum
        FROM Requis r
        JOIN RequisOffre ro ON r.id = ro.idrequis
        JOIN Offre o ON o.id = ro.idoffre
        JOIN Candidature c ON c.idOffre = o.id
        WHERE c.id = idcandidature
    LOOP
        -- Récupérer la valeur dans le profil de la personne
        SELECT p.valeur
        INTO v_profile
        FROM Profile p
        WHERE p.idpersonne = (SELECT idpersonne FROM Candidature WHERE id = idcandidature)
          AND p.idrequis = v_requis.id;

        -- Si aucun profil trouvé, la candidature est incompatible
        IF v_profile.valeur IS NULL THEN
            v_compatible := FALSE;
            v_surcompatible := FALSE;
        ELSE
            -- Comparaison des valeurs du profil avec les requis
            IF v_requis.minimum IS NOT NULL AND v_profile.valeur < v_requis.minimum THEN
                v_compatible := FALSE;
            END IF;

            IF v_requis.maximum IS NOT NULL AND v_profile.valeur > v_requis.maximum THEN
                v_surcompatible := FALSE;
            END IF;
        END IF;
    END LOOP;

    -- Retourner les résultats en fonction de la compatibilité
    IF NOT v_compatible THEN
        RETURN 1;  -- Incompatible
    ELSIF v_surcompatible THEN
        RETURN 3;  -- Surcompatible
    ELSE
        RETURN 2;  -- Compatible
    END IF;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION update_isTaken_offre()
RETURNS TRIGGER AS $$
BEGIN
    -- Vérifier si la candidature en cours est marquée comme prise
    IF NEW.isTaken = true THEN
        -- Vérifier si toutes les candidatures pour l'offre sont prises
        IF NOT EXISTS (
            SELECT 1
            FROM Candidature
            WHERE idOffre = NEW.idOffre AND isTaken = false
        ) THEN
            -- Si toutes les candidatures pour l'offre sont prises, mettre à jour l'offre
            UPDATE Offre
            SET isTaken = true
            WHERE id = NEW.idOffre;
        END IF;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_update_isTaken_offre
AFTER INSERT OR UPDATE ON Candidature
FOR EACH ROW
EXECUTE FUNCTION update_isTaken_offre();


CREATE OR REPLACE view v_cv_dashboard AS
SELECT 
    c.id AS id_candidature,
    p.id AS id_personne,
    p.nom AS nom_personne,
    j.nom AS nom_job,
    c.idcv AS id_cv,
    c.idoffre AS id_offre,
    cv.note_competence AS note_competence,
    cv.note_experience AS note_experience,
    cv.note_education AS note_education,
    ROUND((cv.note_competence + cv.note_experience + cv.note_education) / 3.0, 2) AS moyenne_notes,
    c.datePostule,
    c.etat
FROM 
    Candidature c
JOIN 
    cv ON c.idcv = cv.id
JOIN 
    Personne p ON cv.idpersonne = p.id
JOIN 
    Offre o ON c.idOffre = o.id
JOIN 
    Job j ON o.idJob = j.id;
