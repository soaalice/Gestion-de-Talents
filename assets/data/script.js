let currentTheme = '';
let currentIndex = 0;
let score = 0;
let errors = []; // Liste des erreurs (questions mal répondues)

function escapeSingleQuote(text) {
    return text.replace(/'/g, "\\'");
}

// Mettre à jour les questions dynamiquement
function updateQuestions() {
    const questionContainer = document.getElementById('question-container');
    const questions = questionsData[currentTheme];

    // Vérifier si le quiz est terminé
    if (currentIndex >= questions.length) {
        showResult();
        return;
    }

    // Afficher la question actuelle
    const currentQuestion = questions[currentIndex];
    questionContainer.innerHTML = `
        <p><strong>Question ${currentIndex + 1}:</strong> ${currentQuestion.question}</p>
        ${currentQuestion.choices.map((choice, i) => `
            <label>
                <input type="radio" name="answer" value="${choice}" onclick="checkAnswer('${escapeSingleQuote(choice)}')"> ${choice}
            </label><br>
        `).join('')}
    `;
}

// Vérifier la réponse et passer à la question suivante
function checkAnswer(choice) {
    const questions = questionsData[currentTheme];
    const correctAnswer = questions[currentIndex].answer;

    if (choice === correctAnswer) {
        score++;
    } else {
        // Ajouter la question à la liste des erreurs si réponse incorrecte
        errors.push({
            question: questions[currentIndex].question,
            givenAnswer: choice,
            correctAnswer: correctAnswer,
        });
    }

    currentIndex++;
    updateQuestions();
}

// Afficher les résultats
function showResult() {
    const questionContainer = document.getElementById('question-container');
    const totalQuestions = questionsData[currentTheme].length;

    let errorDetails = '';
    if (errors.length > 0) {
        errorDetails = `
            <h3>Erreurs :</h3>
            <ul>
                ${errors.map(error => `
                    <li>
                        <strong>Question :</strong> ${error.question}<br>
                        <strong>Votre réponse :</strong> ${error.givenAnswer || 'Non répondue'}<br>
                        <strong>Bonne réponse :</strong> ${error.correctAnswer}
                    </li>
                `).join('')}
            </ul>
        `;
    }

    // <button onclick="resetQuiz()">Recommencer</button>
    questionContainer.innerHTML = `
        <h2>Résultats</h2>
        <p>Votre score: <strong>${score} / ${totalQuestions}</strong></p>
        ${errorDetails}
        <div class="row">
        <div class="col-12 my-3">
            <button class="btn btn-primary" id="submit-answers" onclick="resetQuiz()">Recommencer</button>
        </div>
        </div>
    `;
}

// Réinitialiser le quiz
function resetQuiz() {
    currentTheme = '';
    currentIndex = 0;
    score = 0;
    errors = []; // Réinitialiser les erreurs
    document.getElementById('theme-select').value = '';
    document.getElementById('question-container').innerHTML = '';
}

// Initialiser la page
document.addEventListener('DOMContentLoaded', () => {
    const themeSelect = document.getElementById('theme-select');

    themeSelect.addEventListener('change', () => {
        const questionContainer = document.getElementById("question-container");
        currentTheme = themeSelect.value;
        currentIndex = 0;
        score = 0;
        errors = []; // Réinitialiser les erreurs
        updateQuestions();
        // questionContainer.classList.remove("hidden");
        if (!themeSelect || currentTheme!=undefined) {
            questionContainer.classList.remove("hidden");
            return;
        } else {
            questionContainer.classList.add("hidden");
        }
    });
});

