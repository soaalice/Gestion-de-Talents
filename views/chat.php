<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<style>
    /* Style global */
    body {
        font-family: 'Poppins', sans-serif;
    }

    /* Style de la bulle de chat */
    .chat-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff;
        color: white;
        padding: 12px;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .chat-icon:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    /* Fenêtre principale du chat
.chat-box {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 400px;
    height: 500px;
    background-color: #ffffff;
    border-radius: 12px;
    border: 1px solid #ddd;
    display: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.chat-box.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
} */
    /* Fenêtre principale du chat */
    .chat-box {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 40%;
        height: 500px;
        background-color: #ffffff;
        border-radius: 12px;
        border: 1px solid #ddd;
        visibility: hidden;
        opacity: 0;
        transform: translateY(50px);
        transition: visibility 0s 0.3s, opacity 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
    }

    .chat-box.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
        transition: visibility 0s 0s, opacity 0.3s ease, transform 0.3s ease;
    }


    /* Conteneur principal avec sidebar et chat */
    .chat-layout {
        display: flex;
        height: 100%;
        flex-grow: 1;
    }

    /* Sidebar (menu de navigation) */
    .sidebar {
        width: 40%;
        background-color: #007bff;
        color: white;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        justify-content: flex-start;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
        overflow-y: scroll;
        overflow-x: hidden;
    }
    

    /* Titre "Sujets" style similaire à "Chatbot" */
    .sidebar h2 {
        color: white;
        font-size: 16px;
        font-weight: 500;
        text-transform: uppercase;
        margin: 0;
    }

    /* Style des boutons qui ressemblent à des liens */
    .sidebar .button {
        display: block;
        padding: 5px 10px;
        /* Taille plus compacte */
        background-color: transparent;
        /* Fond transparent pour ressembler à un lien */
        color: white;
        text-decoration: none;
        text-align: left;
        /* Aligner le texte à gauche */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        font-size: 14px;
        line-height: 1.4;
    }

    /* Changer la couleur au survol pour donner l'effet d'un lien */
    .sidebar .button:hover {
        background-color: #0056b3;
        color: #e1f5fe;
    }

    /* Zone de chat (en-tête, messages, input) */
    .chat-area {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 0%;
    }

    /* En-tête du chat */
    .chat-header {
        background-color: #007bff;
        color: white;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-right-radius: 12px;
    }

    /* Contenu des messages */
    .chat-content {
        flex-grow: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat-message {
        max-width: 80%;
        padding: 12px 15px;
        border-radius: 20px;
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.2s ease;
    }

    .chat-message.user {
        background-color: #e1f5fe;
        align-self: flex-end;
        border-top-right-radius: 0;
    }

    .chat-message.bot {
        background-color: #f1f1f1;
        align-self: flex-start;
        border-top-left-radius: 0;
    }

    /* Zone de saisie du message */
    .chat-input {
        display: flex;
        padding: 10px;
        background-color: #f8f8f8;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 12px;
    }

    .chat-input input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 25px;
        font-size: 14px;
        outline: none;
        transition: border 0.3s ease;
    }

    .chat-input input:focus {
        border-color: #007bff;
    }

    .chat-input button {
        background-color: #007bff;
        color: white;
        padding: 8px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        margin-left: 10px;
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s ease;
    }

    .chat-input button:hover {
        background-color: #0056b3;
    }

    /* Icône d'envoi */
    .send-icon {
        font-size: 18px;
    }

    /* Bouton de fermeture */
    .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 22px;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #ff4444;
    }
</style>

<div id="chat-icon" class="chat-icon">
    💬
</div>

<!-- Fenêtre de discussion -->
<div class="chat-container">
    <div id="chat-box" class="chat-box">

        <!-- Conteneur principal pour le sidebar et le chat -->
        <div class="chat-layout">

            <!-- Sidebar (menu de navigation) -->
            <div id="sidebar" class="sidebar">
                <h2>Sujets</h2>
                <div id="subjectButtons"></div> <!-- Conteneur pour les boutons -->
            </div>

            <!-- Zone de chat -->
            <div class="chat-area">

                <!-- En-tête -->
                <div class="chat-header">
                    <span>Chatbot</span>
                    <button id="close-btn" class="close-btn">×</button>
                </div>

                <!-- Contenu des messages -->
                <div class="chat-content" id="chat-content">
                    <p style="text-align: center;">Notre assistant virtuel est à votre disposition.</p>
                </div>

                <!-- Zone de saisie -->
                <div class="chat-input">
                    <input type="text" id="user-input" placeholder="Écrivez votre message...">
                    <button id="send-btn">
                        <span class="send-icon">➤</span> <!-- Icône d'envoi -->
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- <script src="script.js"></script> -->

<script>
    // Récupérer les éléments du DOM
    const chatIcon = document.getElementById("chat-icon");
    const chatBox = document.getElementById("chat-box");
    const closeButton = document.getElementById("close-btn");
    const sendButton = document.getElementById("send-btn");
    const userInput = document.getElementById("user-input");
    const chatContent = document.getElementById("chat-content");
    let selectedSubject = null;

    // Fonction pour charger les sujets et créer les boutons dans la sidebar
    async function loadSubjects() {
        try {
            const response = await fetch('http://localhost:5000/get_subjects');
            if (!response.ok) {
                throw new Error(`Erreur réseau : ${response.status} - ${response.statusText}`);
            }
            const data = await response.json();
            console.log('Données reçues depuis l\'API :', data); // Vérifiez les données reçues
            return data.subjects;
        } catch (error) {
            console.error('Erreur lors du chargement des sujets :', error);
            return {};
        }
    }

    function selectSubject(id, name) {
        activateChat();
        selectedSubject = id;
        chatContent.innerHTML = "";
        addMessage("Posez vos questions sur " + name + ".", "bot");
    }

    userInput.addEventListener('keydown', function (event) {
        if (event.key == 'Enter' && userInput.value.trim() !== '') {
            sendButton.click();
        }
    });

    let subjectsLoaded = false; // Variable d'état pour vérifier si les sujets ont été chargés

    // Fonction pour ouvrir ou fermer la fenêtre de chat
    chatIcon.addEventListener("click", async () => {
        if (!subjectsLoaded) {
            // Charger les sujets seulement la première fois que l'icône est cliquée
            const subjectsData = await loadSubjects(); // Attendre que la promesse soit résolue
            const subjects = Object.entries(subjectsData).map(([id, nom]) => ({ id, nom }));

            // Génération dynamique des boutons dans la sidebar
            const container = document.getElementById('subjectButtons');
            subjects.forEach(subject => {
                const button = document.createElement('button');
                button.className = 'button';
                button.textContent = subject.nom;
                button.dataset.subjectId = subject.id;
                button.dataset.subjectName = subject.nom;
                button.addEventListener('click', () => selectSubject(subject.id, subject.nom));
                container.appendChild(button);
            });

            subjectsLoaded = true; // Marquer les sujets comme chargés
        }

        // Ouvrir ou fermer la fenêtre de chat
        chatBox.classList.toggle("show");
    });

    // Fonction pour fermer la fenêtre de chat
    closeButton.addEventListener("click", () => {
        chatBox.classList.remove("show");
    });

    // Fonction pour envoyer un message
    sendButton.addEventListener("click", async () => {
        const userMessage = userInput.value.trim();
        const subjectId = selectedSubject;

        if (userMessage !== "" && subjectId) {
            // Ajouter le message utilisateur dans le chat
            addMessage(userMessage, "user");

            // Réinitialiser le champ de saisie
            userInput.value = "";

            // Ajouter une réponse d'attente du bot
            const messageElement = addMessage("Je recherche une réponse...", "bot");

            // Requête vers l'API Python
            try {
                const response = await fetch('http://localhost:5000/get_response', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        subject_id: parseInt(subjectId),
                        question: userMessage
                    })
                });

                const data = await response.json();

                // Remplacer le message d'attente par la réponse réelle du bot
                const botMessageElement = chatContent.querySelector('.chat-message:last-child');
                if (botMessageElement) {
                    setTimeout(() => {
                        botMessageElement.textContent = data.response;
                        chatContent.scrollTop = chatContent.scrollHeight;
                    }, 1000);
                }

            } catch (error) {
                console.log(error);
                // Gérer l'erreur en mettant un message d'erreur
                const botMessageElement = chatContent.querySelector('.chat-message:last-child');
                if (botMessageElement) {
                    botMessageElement.textContent = "Désolé, il y a eu un problème avec la requête.";
                }
            }

            // Défilement automatique vers le bas
            chatContent.scrollTop = chatContent.scrollHeight;
        }
    });

    // Fonction pour ajouter un message dans la fenêtre de chat
    function addMessage(message, sender) {
        const messageElement = document.createElement("div");
        messageElement.classList.add("chat-message", sender);
        messageElement.textContent = message;

        messageElement.style.opacity = 0; // Commence avec une opacité de 0
        chatContent.appendChild(messageElement);

        // Animation de fondu en 0.5 secondes
        setTimeout(() => {
            messageElement.style.transition = "opacity 0.5s ease-in-out"; // Ajouter la transition
            messageElement.style.opacity = 1; // Faire apparaître le message
        }, 30);

        // chatContent.appendChild(messageElement);
        chatContent.scrollTop = chatContent.scrollHeight;
        return messageElement;
    }

    // Fonction pour activer & desactiver le chat
    function activateChat() {
        userInput.disabled = false;
    }
    function desactivateChat() {
        userInput.disabled = true;
    }

    addMessage("Bienvenue, choisissez un sujet pour commencer.", "bot");
    desactivateChat();

    // Utilisation correcte de la fonction asynchrone pour charger les sujets
    // (async function() {
    //     const subjectsData = await loadSubjects(); // Attendre que la promesse soit résolue

    //     // Transformation de l'objet en un tableau d'objets
    //     const subjects = Object.entries(subjectsData).map(([id, nom]) => ({ id, nom }));

    //     // Génération dynamique des boutons dans la sidebar
    //     const container = document.getElementById('subjectButtons');
    //     subjects.forEach(subject => {
    //         const button = document.createElement('button');
    //         button.className = 'button';
    //         button.textContent = subject.nom;
    //         button.dataset.subjectId = subject.id;
    //         button.dataset.subjectName = subject.nom;
    //         button.addEventListener('click', () => selectSubject(subject.id, subject.nom));
    //         container.appendChild(button);
    //     });
    // })();
</script>