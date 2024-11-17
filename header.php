<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="<?php echo $perso ?>">
    <style>
        /* Bulle flottante */
        .bulle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #4a90e2;
            color: white;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.4s ease-in-out;
        }

        .bulle:hover {
            transform: scale(1.1);
        }

        /* Conteneur du chat */
        .chat-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 300px;
            max-height: 400px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            z-index: 10;
            transform: scale(0);
            transform-origin: bottom right;
            transition: transform 0.5s ease-in-out;
        }

        .chat-container.open {
            transform: scale(1);
        }

        /* Header du Chat */
        .chat-header {
            background-color: #4a90e2;
            color: white;
            padding: 15px;
            font-weight: bold;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            position: relative;
        }

        .chat-footer {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-footer input {
            flex-grow: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 5px;
        }

        .chat-footer button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background-color: #357ab7;
        }

        /* Style des Messages */
        .chat-messages {
            padding: 10px;
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chat-messages p {
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 15px;
            max-width: 70%;
            position: relative;
            font-size: 14px;
            word-wrap: break-word;
            transition: transform 0.3s ease-in-out;
        }

        /* Messages de l'utilisateur */
        .chat-messages .user-message {
            background-color: #4a90e2;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 0px;
        }

        /* Messages du bot */
        .chat-messages .bot-message {
            background-color: #f1f1f1;
            color: #333;
            align-self: flex-start;
            border-bottom-left-radius: 0px;
        }

        /* Menu Options à côté du chat */
        /* Menu Options à côté du chat */
        .menu-options {
            position: fixed;
            bottom: 100px;
            right: 340px;
            /* Positionner à gauche du chat */
            width: 200px;
            height: 209px;
            max-height: 209px;
            overflow-y: scroll;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 15;
            padding: 10px;
            transform: scale(0);
            /* Par défaut, le menu est réduit */
            transform-origin: bottom right;
            transition: transform 0.3s ease, opacity 0.3s ease;
            /* Transition ajoutée pour l'animation */
        }

        .menu-options.open {
            display: block;
            transform: scale(1);
            /* Agrandir le menu lors de l'ouverture */
            opacity: 1;
            /* Ajouter une transition de l'opacité pour améliorer l'animation */
        }


        .menu-options ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-options ul li {
            margin: 10px 0;
        }

        .menu-options ul li a {
            text-decoration: none;
            color: #4a90e2;
            font-weight: bold;
        }

        /* Hover sur les liens du menu */
        .menu-options ul li a:hover {
            color: #357ab7;
        }

        /* Animation des messages */
        @keyframes appear {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-messages p {
            animation: appear 0.3s ease-out;
        }
    </style>
    <title>Document</title>
</head>

<body style="background-color: #eaf4f0;"> <!-- Arrière-plan apaisant -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #107c41;">
        <!-- Fond vert clair naturel -->
        <div class="container-fluid">
            <!-- Logo / Title -->
            <a class="navbar-brand" href="index.php" style="color: #d2f1d4; font-weight: bold;">Talent Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navbar links -->
                <ul class="navbar-nav ms-auto">
                    <?php $role = $user->getRole(); ?>
                    <?php if (isset($role) || !empty($role)) { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php" style="color: #d2f1d4;">Role : <strong
                                    style='color: #ffffff;'><?php echo $role ?></strong></a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link active" href="index.php" style="color: #d2f1d4;">Home</a>
                    </li>
                    <?php if ($user->isAuthentified()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=logout" style="color: #d2f1d4;">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=login" style="color: #d2f1d4;">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=register" style="color: #d2f1d4;">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="bulle" onclick="toggleChat()">
        <i class="fas fa-message"></i>
    </div>

    <div class="chat-container" id="chatContainer">
        <div class="chat-header">
            Assistant Virtuel
        </div>
        <div class="chat-messages" id="chatMessages">
            <p>Bonjour ! Comment puis-je vous aider ?</p>
        </div>
        <div class="chat-footer">
            <input type="text" placeholder="Votre message..." id="userMessage" />
            <button onclick="sendMessage()">Envoyer</button>
        </div>
    </div>

    <!-- Menu Options à côté du chat -->
    <div class="menu-options" id="menuOptions">
        <div class="chat-header">
            Option de chat
        </div>
        <ul>
            <li><a href="#"><i class="fas fa-arrow-right mx-1"></i> Option 1</a></li>
            <li><a href="#"><i class="fas fa-arrow-right mx-1"></i> Option 1</a></li>
            <li><a href="#"><i class="fas fa-arrow-right mx-1"></i> Option 1</a></li>
            <li><a href="#"><i class="fas fa-arrow-right mx-1"></i> Option 1</a></li>
            <li><a href="#"><i class="fas fa-arrow-right mx-1"></i> Option 2</a></li>
            <li><a href="#"><i class="fas fa-arrow-right mx-1"></i> Option 3</a></li>
        </ul>
    </div>

    <script>
        function toggleChat() {
            const chatContainer = document.getElementById('chatContainer');
            const menuOptions = document.getElementById('menuOptions');
            chatContainer.classList.toggle('open');
            if (chatContainer.classList.contains('open')) {
                menuOptions.classList.add('open'); // Afficher le menu à côté
            } else {
                menuOptions.classList.remove('open'); // Cacher le menu
            }
        }

        function sendMessage() {
            const messageInput = document.getElementById('userMessage');
            const messageText = messageInput.value.trim();
            if (messageText) {
                const messageElement = document.createElement('p');
                messageElement.classList.add('user-message');
                messageElement.textContent = messageText;
                document.getElementById('chatMessages').appendChild(messageElement);
                messageInput.value = '';
                scrollToBottom();
                botResponse();
            }
        }

        function botResponse() {
            const botMessage = document.createElement('p');
            botMessage.classList.add('bot-message');
            botMessage.textContent = "Merci pour votre message, je vais y répondre.";
            document.getElementById('chatMessages').appendChild(botMessage);
            scrollToBottom();
        }

        function scrollToBottom() {
            const messages = document.getElementById('chatMessages');
            messages.scrollTop = messages.scrollHeight;
        }
    </script>