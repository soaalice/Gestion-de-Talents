document.addEventListener("DOMContentLoaded", () => {
    let gridday = document.querySelectorAll(".fc-daygrid-day");
    const toolbar = document.querySelectorAll(".fc-toolbar-chunk");
    const dateinputs = document.querySelectorAll(".daty"); // Sélectionne tous les inputs avec la classe "daty"
    let activeInput = null; // Variable pour suivre l'input actif

    // Écouteurs pour détecter l'input actif
    dateinputs.forEach(input => {
        input.addEventListener("focus", () => {
            console.log("Input actif :", input);
            activeInput = input; // Met à jour l'input actif
        });
    });

    // Fonction pour comparer les dates
    const validateDates = () => {
        if (dateinputs.length >= 2) {
            const date1 = new Date(dateinputs[0].value);
            const date2 = new Date(dateinputs[1].value);

            if (dateinputs[0].value && dateinputs[1].value) {
                if (date1 > date2) {
                    alert("La première date doit être antérieure ou égale à la deuxième date.");
                    dateinputs[1].value = ""; // Réinitialise la deuxième date
                }
            }
        }
    };

    // Fonction pour ajouter des écouteurs de clic aux éléments gridday
    const addClickListeners = () => {
        gridday.forEach(element => {
            element.addEventListener("click", () => {
                const date = element.getAttribute("data-date");
                console.log("Date sélectionnée :", date);

                // Vérifie s'il y a un input actif et le met à jour
                if (activeInput) {
                    activeInput.value = date;

                    // Valide les dates après la mise à jour
                    validateDates();
                }
            });
        });
    };

    // Ajout des écouteurs initiaux
    addClickListeners();

    // Mise à jour des écouteurs après clic sur la barre d'outils
    toolbar.forEach(element => {
        element.addEventListener('click', () => {
            // Requête des éléments gridday après modification de l'interface
            gridday = document.querySelectorAll(".fc-daygrid-day");
            addClickListeners();
        });
    });
});
