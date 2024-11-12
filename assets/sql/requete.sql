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

