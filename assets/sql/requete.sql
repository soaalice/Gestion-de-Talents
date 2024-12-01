select 
    r.nom,
    ro.minimum,
    ro.maximum
from 
    requisoffre ro
join 
    requis r 
ON
    r.id = ro.idrequis
where idoffre = ?;

select 
    j.nom,
    of.dateOffre,
    of.salaire 
from 
    offre of
join 
    job j
on
    j.id = of.idjob;
where j.id = ?;

select 
    pf.id,
    pf.idpersonne as idpersonne,
    pers.nom as nom_personne,
    pf.idrequis as idrequis,
    r.nom as nom_requis,
    pf.valeur
from 
    profile pf
join 
    personne pers
on
    pf.idpersonne = pers.id
join 
    requis r
on 
    pf.idrequis = r.id;

SELECT 
    rof.id AS requis_offre_id,
    r.nom AS nom_requis,
    rof.minimum AS minimum_requis,
    rof.maximum AS maximum_requis,
    p.valeur AS valeur_personne
FROM 
    RequisOffre rof
JOIN 
    Requis r ON rof.idrequis = r.id
JOIN 
    Offre o ON rof.idoffre = o.id
JOIN 
    Candidature c ON c.idOffre = o.id
JOIN 
    Profile p ON p.idrequis = r.id
JOIN 
    Personne pe ON pe.id = p.idpersonne
WHERE 
    o.id = 1  -- Remplacez par l'ID de l'offre recherchée
    AND pe.id = 1;

SELECT 
    p.nom AS "Nom de la Personne",
    r.nom AS "Requis",
    ro.minimum AS "Minimum Requis",
    ro.maximum AS "Maximum Requis",
    pr.valeur AS "Valeur dans le Profil"
FROM 
    Candidature c
JOIN 
    Personne p ON c.idpersonne = p.id
JOIN 
    Offre o ON c.idOffre = o.id
JOIN 
    RequisOffre ro ON o.id = ro.idoffre
JOIN 
    Requis r ON ro.idrequis = r.id
LEFT JOIN 
    Profile pr ON pr.idpersonne = p.id AND pr.idrequis = r.id
WHERE 
    c.idpersonne = 3 and c.idoffre = 2
    AND c.isTaken = FALSE;


SELECT 
    p.nom AS nom_candidat,
    o.dateOffre AS dateoffre,
    j.nom AS nom_job,
    o.salaire AS salaire,
    r.nom AS nom_requis,
    ro.minimum AS minimum,
    ro.maximum AS maximum,
    pr.valeur AS valeur
FROM 
    Candidature c
JOIN 
    Personne p ON c.idpersonne = p.id
JOIN 
    Offre o ON c.idOffre = o.id
JOIN 
    Job j ON o.idjob = j.id  -- Récupère le nom du job depuis la table Job
JOIN 
    RequisOffre ro ON o.id = ro.idoffre
JOIN 
    Requis r ON ro.idrequis = r.id
LEFT JOIN 
    Profile pr ON pr.idpersonne = p.id AND pr.idrequis = r.id
WHERE 
    c.idpersonne = 3 and c.idoffre = 2 -- Remplacez <ID_PERSONNE> par l'identifiant de la personne
    AND c.isTaken = FALSE; -- Filtre sur les candidatures non prises (si nécessaire)



-------------------------------------------------------------------------------

SELECT 
    employe_id,
    DATE_TRUNC('week', date) AS semaine, -- Début de la semaine
    SUM(heures_travail) AS total_heures_supplementaires -- Total des heures par semaine
FROM HeuresSupplementaires
WHERE employe_id = 1 -- Remplacez 1 par l'ID de l'employé
  AND DATE_TRUNC('month', date) = '2024-11-01' -- Mois de novembre 2024
GROUP BY employe_id, DATE_TRUNC('week', date)
ORDER BY semaine;
