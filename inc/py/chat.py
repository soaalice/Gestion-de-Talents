from flask import Flask, request, jsonify
from flask_cors import CORS  # Importer CORS

app = Flask(__name__)
CORS(app)

subjects = {
    1: 'Candidature',
    2: 'Entretien',
    3: 'Test technique',
    4: 'Réponse de l\'entreprise',
    5: 'Offre d\'emploi',
    6: 'Intégration dans l\'entreprise',
    7: 'Rétroaction sur l\'entretien',
    8: 'Salaire et avantages',
    9: 'Formation professionnelle',
}

synonymes = {
    "lieu": ("site", "emplacement", "endroit", "lieu de rendez-vous", "endroit", "où"),
    "durée": ("temps", "intervalle", "longueur", "période"),
    "déroulement": ("processus", "méthode", "plan", "procédure", "se passera"),
    "recruteurs": ("intervieweurs", "responsables RH", "évaluateurs"),
    "critères": ("standards", "exigences", "conditions", "évaluations"),
    "étapes": ("phases", "séquences", "stades", "procédures"),
    "processus": ("procédure", "méthode", "workflow", "approche"),
    "délai": ("temps de réponse", "attente", "délai de traitement"),
    "suivi": ("monitoring", "progression"),
    "documents": ("papier", "fichiers", "dossiers"),
    "contact": ("demander des nouvelles", "contacter", "suivi"),
    "format": ("type", "forme", "structure"),
    "difficulté": ("complexité", "niveau de difficulté", "facilité"),
    "feedback": ("retours", "avis", "commentaires"),
    "évaluation": ("épreuve", "test", "analyse"),
    "acceptation": ("offre acceptée", "réponse positive", "confirmation"),
    "refus": ("rejet", "non retenu", "décision négative"),
    "négociation": ("discussions", "ajustement", "révision"),
    "réponse": ("réaction", "réponse officielle", "réponse finale"),
    "changement": ("modifications", "ajustements", "révisions"),
    "onboarding": ("intégration", "accueil", "formation initiale"),
    "activités": ("évenements", "activités sociales", "réunions"),
    "demande": ("demander", "requête", "sollicitation"),
    "nature": ("type de retour", "forme du feedback", "nature des commentaires"),
    "salaire": ("rémunération", "compensation", "revenu"),
    "avantages": ("bénéfices", "prestations", "extras"),
    "offre": ("proposition", "offre d'emploi", "proposition de travail"),
    "niveau": ("difficulté", "level")
}

# Dictionnaire des réponses par sujet et sous-question
responses = {
    "Entretien": {
        "lieu": "L'entretien peut avoir lieu soit en présentiel dans nos locaux, soit en visio ou par téléphone selon la situation.",
        "durée": "L'entretien dure généralement entre 45 minutes et 1 heure.",
        "déroulement": "L'entretien commence par une présentation de l'entreprise et du poste, suivie d'une série de questions sur votre expérience et compétences.",
        "recruteurs": "En général, il y a 1 ou 2 recruteurs lors de l'entretien.",
        "critères": "Les critères de jugement incluent vos compétences techniques, votre adéquation avec la culture d'entreprise, et vos motivations pour le poste.",
        "étapes": "Les étapes de l'entretien comprennent une première rencontre téléphonique, suivie d'un entretien plus approfondi avec un ou deux recruteurs.",
        "préparation": "Il est conseillé de bien se préparer en révisant votre CV, en connaissant l'entreprise et en réfléchissant aux questions que vous pourriez poser.",
        "questions fréquentes": "Les questions fréquentes portent souvent sur votre expérience professionnelle, votre gestion des défis, vos réussites passées, et pourquoi vous souhaitez rejoindre l'entreprise.",
        "tests techniques": "Dans certains cas, un test technique peut être prévu pour évaluer vos compétences spécifiques en lien avec le poste.",
        "feedback": "A la fin de l'entretien, il est courant de demander un retour sur votre performance ou de poser des questions sur les étapes suivantes du processus de recrutement.",
        "attentes": "Il est important de bien comprendre les attentes du recruteur concernant le poste afin de montrer que vos compétences et votre personnalité correspondent aux besoins de l'entreprise.",
        "motivation": "Les recruteurs cherchent à évaluer votre motivation et votre capacité à vous projeter à long terme dans le poste proposé.",
        "habilité à travailler sous pression": "Certaines questions peuvent évaluer votre capacité à travailler sous pression ou à gérer des situations complexes ou stressantes.",
        "tenue vestimentaire": "La tenue vestimentaire doit être professionnelle. Pour un entretien en visio, assurez-vous d’être bien habillé et dans un environnement calme.",
        "suivi": "Après l'entretien, il est recommandé d'envoyer un email de remerciement pour exprimer votre gratitude et votre intérêt pour le poste."
    },
    "Candidature": {
        "processus": "Le processus de candidature commence par la soumission de votre CV et lettre de motivation sur notre plateforme de recrutement.",
        "délai": "Le délai pour une réponse après l'envoi de votre candidature est généralement de 1 à 2 semaines.",
        "suivi": "Après avoir postulé, vous pouvez suivre l'état de votre candidature sur notre plateforme de recrutement.",
        "documents": "Nous vous demandons de soumettre votre CV, une lettre de motivation et éventuellement des exemples de travaux ou un portfolio, selon le poste.",
        "contact": "Si vous n'avez pas de nouvelles après 3 semaines, vous pouvez nous contacter via notre support pour avoir des informations sur l'état de votre candidature.",
        "confidentialité": "Tous les documents et informations que vous soumettez lors de la candidature sont traités de manière confidentielle et utilisées uniquement dans le cadre de votre recrutement.",
        "candidature spontanée": "Si vous ne trouvez pas de poste correspondant, vous pouvez également soumettre une candidature spontanée via notre plateforme. Nous la garderons en considération pour de futures opportunités.",
        "relecture": "Avant de soumettre votre candidature, prenez le temps de relire vos documents pour vous assurer qu'ils sont à jour et sans erreurs.",
        "pré-sélection": "Une fois votre candidature reçue, elle sera examinée par notre équipe RH qui effectuera une pré-sélection avant de vous contacter pour un entretien.",
        "ajustement de candidature": "Si un poste similaire devient disponible, nous pourrons vous contacter en fonction de votre candidature initiale, même si vous n'avez pas été retenu pour le premier poste.",
        "qualités recherchées": "Les recruteurs recherchent des candidats qui démontrent des compétences spécifiques liées au poste ainsi qu'une bonne motivation et adéquation avec les valeurs de l'entreprise.",
        "confirmation de candidature": "Lorsque vous soumettez votre candidature, vous recevrez un email de confirmation. Si vous ne le recevez pas, vérifiez votre dossier de spam ou contactez-nous.",
        "rejet de candidature": "Si votre candidature n'est pas retenue, vous recevrez un email de notification. Nous vous encourageons à postuler à nouveau pour d'autres opportunités qui pourraient correspondre à votre profil.",
        "entretien de sélection": "Si votre candidature est retenue, vous serez invité à un entretien qui pourra être téléphonique, en visio, ou en présentiel selon les circonstances.",
        "comportement lors de la candidature": "Nous valorisons une approche professionnelle et respectueuse lors du processus de candidature, que ce soit dans la qualité des documents soumis ou dans la communication avec notre équipe."
    },
    "Test technique": {
        "format": "Le test technique est généralement composé de 5 à 10 questions pratiques sur des outils ou technologies spécifiques.",
        "durée": "La durée du test technique varie en fonction du poste, mais en moyenne il dure entre 1 et 2 heures.",
        "difficulté": "La difficulté du test technique dépend du niveau du poste pour lequel vous postulez. Les tests pour des postes juniors sont moins complexes.",
        "feedback": "Une fois le test passé, vous recevrez un retour sur vos résultats, avec éventuellement des conseils pour améliorer vos compétences.",
        "évaluation": "Le test est évalué en fonction de la pertinence des réponses, de la rapidité d'exécution et de la qualité du code ou des solutions proposées.",
        "format en ligne": "Les tests techniques sont souvent administrés en ligne via une plateforme dédiée, et peuvent inclure des exercices de codage, des QCM, ou des études de cas.",
        "ressources autorisées": "Les ressources externes comme les documents de référence ou les forums sont parfois autorisées pour certaines questions, mais cela dépend des règles spécifiées avant le test.",
        "révisions recommandées": "Nous recommandons de revoir les principales technologies ou outils mentionnés dans la description du poste avant de passer le test.",
        "niveau": "Pour des postes plus avancés, le test peut inclure des scénarios plus complexes, demandant de démontrer des compétences en architecture, optimisation ou gestion de projet.",
        "accompagnement pendant le test": "Dans certains cas, vous pouvez bénéficier d'un support technique minimal en cas de problème technique, mais aucune aide directe sur le contenu des questions n'est permise.",
        "conditions de réussite": "Pour réussir le test, il est essentiel de répondre correctement à un nombre significatif de questions et de fournir des solutions complètes et bien expliquées.",
        "temps limité": "Le test est généralement chronométré, vous devrez donc gérer efficacement votre temps pour compléter toutes les questions dans le délai imparti.",
        "simulation préalable": "Il est possible de réaliser une simulation ou un test d'entraînement en ligne pour vous familiariser avec le format et le type de questions avant de passer le test réel.",
        "questions de niveau supérieur": "Les candidats qui réussissent bien les premières questions peuvent être invités à résoudre des problèmes plus complexes, permettant de tester leur créativité et leur capacité à résoudre des défis plus difficiles.",
        "questions comportementales": "En complément des questions techniques, certains tests peuvent inclure des questions sur vos expériences passées ou des mises en situation professionnelles pour évaluer vos compétences transversales.",
        "retour détaillé": "Le feedback sur votre test technique peut inclure des détails sur les erreurs commises, des suggestions pour améliorer vos méthodes de travail et des recommandations pour progresser sur certaines technologies."
    },
    "Réponse de l'entreprise": {
        "délai": "Vous recevrez une réponse dans un délai de 1 à 2 semaines après l'entretien.",
        "format": "La réponse peut être envoyée par e-mail ou par téléphone, selon votre préférence.",
        "acceptation": "Si vous êtes retenu, nous vous enverrons une offre formelle comprenant le salaire, les avantages et les conditions de travail.",
        "refus": "En cas de refus, nous vous expliquerons les raisons de cette décision et vous pourrez demander des retours constructifs.",
        "communication": "Nous nous efforçons d'être transparents et clairs dans notre communication. Si nous avons besoin de plus de temps pour prendre une décision, nous vous en informerons.",
        "offre verbale": "Avant de vous envoyer une offre écrite, nous vous ferons parfois une offre verbale pour discuter des conditions de travail et des attentes de part et d'autre.",
        "détails de l'offre": "L'offre d'embauche détaillera non seulement le salaire, mais aussi les avantages sociaux, la date de début et les modalités d'intégration.",
        "offre conditionnelle": "Dans certains cas, l'offre peut être conditionnelle à la réussite d'une vérification des références ou d'autres démarches administratives.",
        "délai de réponse à l'offre": "Après réception de l'offre, vous disposerez généralement d'une semaine pour accepter ou décliner l'offre. Si vous avez besoin de plus de temps, n'hésitez pas à nous le faire savoir.",
        "revue de l'offre": "Si des aspects de l'offre ne vous conviennent pas, vous pouvez en discuter avec nous. Nous serons ouverts à la négociation dans la mesure du raisonnable.",
        "entretien final": "Dans certains cas, une dernière rencontre peut avoir lieu après l'entretien pour finaliser les conditions ou répondre à des questions de dernière minute avant de faire une offre formelle.",
        "retour après le refus": "Si votre candidature est rejetée, nous vous fournirons des commentaires sur les raisons du refus, ainsi que des suggestions pour améliorer vos candidatures futures.",
        "maintien en considération": "Si vous n'êtes pas retenu pour ce poste mais que votre profil est intéressant, nous pouvons le conserver en vue de futures opportunités qui correspondraient mieux à vos compétences.",
        "réponses différées": "Il peut arriver que, en raison de circonstances imprévues, la réponse prenne un peu plus de temps. Si tel est le cas, nous vous tiendrons informé de l'avancement du processus.",
        "appels de suivi": "Dans certains cas, un appel téléphonique de suivi peut être organisé pour discuter plus en détail de l'offre ou des prochaines étapes du processus."
    },
    "Offre d'emploi": {
        "détails": "L'offre d'emploi détaillera les responsabilités du poste, les compétences requises, les avantages sociaux, le salaire et les conditions de travail.",
        "négociation": "Vous pouvez négocier certains aspects de l'offre, notamment le salaire ou les horaires de travail, selon vos priorités.",
        "réponse": "Vous devrez répondre à l'offre d'ici une semaine après sa réception, pour confirmer votre volonté de rejoindre l'entreprise.",
        "changement": "Si vous avez des questions concernant les avantages ou les conditions de travail, vous pouvez les poser avant de signer l'offre."
    },
    "Intégration dans l'entreprise": {
        "onboarding": "Le processus d'intégration comprend une série de formations pour vous familiariser avec nos outils, nos processus et la culture de l'entreprise.",
        "durée": "L'intégration dure généralement 1 à 2 semaines, avec des sessions de formation et des rencontres avec vos collègues et responsables.",
        "suivi": "Nous organisons des suivis réguliers pendant vos premières semaines pour nous assurer que vous vous sentez à l'aise et que vous avez toutes les ressources nécessaires.",
        "activités": "Des activités de groupe et des réunions d'équipe sont organisées pour vous aider à mieux connaître l'entreprise et vos collègues.",
        "parrainage": "Un parrain ou une marraine pourra vous accompagner pendant votre intégration, vous apportant des conseils pratiques et répondant à vos questions.",
        "objectifs de l'intégration": "Les premiers mois sont souvent consacrés à la prise en main de votre poste et à l'atteinte de premiers objectifs à court terme, afin de vous aider à vous installer dans vos fonctions.",
        "rencontres avec la direction": "Lors de votre intégration, vous serez invité à rencontrer des membres clés de la direction pour mieux comprendre la vision stratégique et les projets à venir de l'entreprise."

    },
    "Rétroaction sur l'entretien": {
        "demande": "Si vous souhaitez obtenir des retours sur votre entretien, vous pouvez envoyer un e-mail à notre responsable des ressources humaines.",
        "délai": "Les retours peuvent être donnés dans un délai de 1 à 2 semaines après votre entretien.",
        "nature": "Les retours incluent généralement des commentaires sur vos points forts, vos axes d'amélioration et votre adéquation au poste.",
        "constructivité": "Nous nous efforçons de donner des retours constructifs pour vous aider à progresser dans vos futures candidatures ou entretiens.",
        "feedback détaillé": "Les retours peuvent couvrir des aspects techniques de l'entretien, des compétences comportementales, et de votre approche générale pendant l'entretien.",
        "réactions aux questions": "Nous pouvons également donner un retour sur votre manière de répondre aux questions, en soulignant vos réussites et en suggérant des améliorations possibles dans vos réponses."
    },
    "Salaire et avantages": {
        "salaire": "Le salaire proposé dépend du poste, de votre expérience et de la grille salariale de l'entreprise.",
        "avantages": "En plus du salaire, l'entreprise offre des avantages comme une mutuelle, des tickets restaurant, un plan de retraite, et des formations professionnelles.",
        "négociation": "Vous pouvez discuter de certains aspects de l'offre, comme le salaire ou les avantages, lors de l'entretien final ou après l'offre.",
        "bonus et primes": "Des primes ou des bonus peuvent être proposés en fonction de la performance individuelle, des résultats de l'équipe ou des performances de l'entreprise.",
        "évolution salariale": "L'entreprise offre des possibilités d'évolution salariale régulières basées sur la performance, l'expérience et la contribution au succès de l'entreprise.",
        "télétravail": "L'entreprise propose des options de télétravail flexibles, selon la nature du poste et les préférences de l'employé.",
        "réévaluation annuelle": "Le salaire est réévalué chaque année dans le cadre des entretiens annuels de performance, avec possibilité de réajustement en fonction des résultats individuels et des évolutions de l'entreprise."
    },
    "Formation professionnelle": {
        "offre": "L'entreprise propose des formations régulières, notamment pour les nouveaux outils, les compétences techniques ou le développement personnel.",
        "types": "Les formations incluent des séminaires, des ateliers en ligne, et des formations internes sur des sujets comme la gestion de projet ou la communication.",
        "accès": "Tous les employés ont accès à une plateforme de formation en ligne, avec des cours gratuits ou remboursés par l'entreprise.",
        "certifications": "L'entreprise soutient les employés dans l'obtention de certifications professionnelles pertinentes pour leur développement et leur progression de carrière.",
        "plan de développement personnel": "Chaque employé peut bénéficier d'un plan de développement personnalisé, élaboré en collaboration avec son manager, pour évoluer dans son rôle et acquérir de nouvelles compétences.",
        "mentorat": "Des programmes de mentorat peuvent être proposés pour vous aider à progresser dans votre carrière, en vous mettant en relation avec des employés plus expérimentés.",
        "budget de formation": "Un budget de formation est mis à disposition pour chaque employé afin de favoriser son apprentissage continu et sa montée en compétences."
    }
}

# def get_detailed_response(subject_id, question):
#     subject = subjects.get(subject_id)
#     if not subject:
#         return "Désolé, je n'ai pas de réponse pour ce sujet."

#     question = question.lower()
    
#     for keyword, response in responses[subject].items():
#         if keyword in question:
#             return response
    
#     # Réponse de clarification
#     suggestions = ", ".join([f'"{key}"' for key in responses[subject].keys()])
#     return f"Je n'ai pas compris votre question.\nVous pouvez demander plus d'informations à propos de : {suggestions}."

def get_detailed_response(subject_id, question):
    subject = subjects.get(subject_id)
    if not subject:
        return "Désolé, je n'ai pas de réponse pour ce sujet."
    
    question = question.lower()
    
    # Vérifier les mots-clés et leurs synonymes
    for keyword, response in responses[subject].items():
        # Vérifier le mot-clé exact
        if keyword in question:
            return response
        
        # Vérifier les synonymes associés au mot-clé
        if keyword in synonymes:
            for syn in synonymes[keyword]:
                if syn in question:
                    return response
    
    # Réponse de clarification
    suggestions = ", ".join([f'"{key}"' for key in responses[subject].keys()])
    return f"Je n'ai pas compris votre question.\nVous pouvez demander plus d'informations à propos de : {suggestions}."

# Route pour obtenir une réponse à une question
@app.route('/get_response', methods=['POST'])
def get_response():
    data = request.json
    subject_id = data.get("subject_id")  # Utiliser "subject_id" pour l'ID du sujet
    question = data.get("question", "")
    
    response_text = get_detailed_response(subject_id, question)
    
    return jsonify({"response": response_text})

@app.route('/get_subjects', methods=['GET'])
def get_subjects():
    return jsonify({"subjects" : subjects})

if __name__ == '__main__':
    app.run(debug=True)
