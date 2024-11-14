<?php
header('Content-Type: text/html; charset=UTF-8');
?>
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

        /* Chat Container */
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

        /* Hover sur les messages */
        .chat-messages .user-message:hover {
            background-color: #357ab7;
            transform: scale(1.05);
        }

        .chat-messages .bot-message:hover {
            background-color: #dcdcdc;
            transform: scale(1.05);
        }

        /* Extension de Chat */
        .contenue-2 {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 300px;
            max-height: 400px;
            background-color: #f1f1f1;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            z-index: 9;
            transform: scale(0);
            animation: coulisseSort 0.5s ease-in-out forwards;
        }

        .contenue-2.open {
            transform: scale(1);
            display: flex;
            animation: coulisse 0.5s ease-in-out forwards;
        }

        @keyframes coulisseSort {
            0% {
                /* right: 30px; */
                transform: translateX(-300px);
            }

            100% {
                /* right: 330px; */
                transform: translateX(0);
                display: none;
            }
        }
        @keyframes coulisse {
            0% {
                /* right: 30px; */
                transform: translateX(0);
            }

            100% {
                /* right: 330px; */
                transform: translateX(-300px);
            }
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
                                    style='color: #d2f1d4;'><?php echo $role ?></strong></a>
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
            <span class="more-options" onclick="toggleExtension()">&#8230;</span>
        </div>
        <div class="chat-messages" id="chatMessages">
            <p>Bonjour ! Comment puis-je vous aider ?</p>
        </div>
        <div class="chat-footer">
            <input type="text" placeholder="Votre message..." id="userMessage" />
            <button onclick="sendMessage()">Envoyer</button>
        </div>
    </div>

    <!-- Extension de Chat -->
    <div class="contenue-2" id="contenue2">
        <div style="padding: 15px; font-weight: bold; color: #4a90e2;">Extension</div>
        <div style="padding: 10px;">Contenu supplémentaire ou options ici...</div>
    </div>

    <script>
        function toggleChat() {
            const chatContainer = document.getElementById('chatContainer');
            const extensionContainer = document.getElementById('contenue2');
            chatContainer.classList.toggle('open');
            if(extensionContainer.classList.contains('open')){
                extensionContainer.classList.remove('open');    
            }
        }

        function toggleExtension() {
            const extensionContainer = document.getElementById('contenue2');
            extensionContainer.classList.toggle('open');
        }

        function sendMessage() {
            const chatMessages = document.getElementById('chatMessages');
            const userMessageInput = document.getElementById('userMessage');
            const messageText = userMessageInput.value.trim();

            if (messageText) {
                // Créer le message de l'utilisateur
                const userMessage = document.createElement('p');
                userMessage.classList.add('user-message');
                userMessage.textContent = messageText;
                chatMessages.appendChild(userMessage);

                // Effacer l'input
                userMessageInput.value = '';

                // Répondre avec un message du bot
                setTimeout(() => {
                    const botMessage = document.createElement('p');
                    botMessage.classList.add('bot-message');
                    botMessage.textContent = "Merci pour votre message ! Je vais y réfléchir.";
                    chatMessages.appendChild(botMessage);

                    // Faire défiler les messages vers le bas
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 500);
            }
        }
    </script>