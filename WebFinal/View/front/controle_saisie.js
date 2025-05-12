document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form'); // ou '.custom-form' si tu veux être plus précis

    form.addEventListener('submit', function (event) {
        let valid = true;

        // Réinitialiser les messages d'erreur
        resetErrors();

        // Validation du montant
        const montant = document.getElementById('montant');
        if (!montant.value || isNaN(montant.value) || Number(montant.value) <= 0) {
            valid = false;
            document.getElementById('montantError').textContent = "Veuillez entrer un montant valide.";
            document.getElementById('montantError').style.display = "block";
        }

        // Validation de la devise
        const devise = document.getElementById('devise');
        if (!devise.value || devise.selectedIndex === 0) {
            valid = false;
            document.getElementById('deviseError').textContent = "Veuillez choisir une devise.";
            document.getElementById('deviseError').style.display = "block";
        }

        // Validation de la méthode
        const methode = document.getElementById('methode');
        if (!methode.value || methode.selectedIndex === 0) {
            valid = false;
            document.getElementById('methodeError').textContent = "Veuillez choisir une méthode de paiement.";
            document.getElementById('methodeError').style.display = "block";
        }

        // Validation du numéro de carte (si autre que Cash)
        const carte = document.getElementById('carte');
        if (methode.value !== "Cash") {
            if (!carte.value || !/^\d{12,19}$/.test(carte.value)) {
                valid = false;
                document.getElementById('carteError').textContent = "Veuillez entrer un numéro de carte valide (12 à 19 chiffres).";
                document.getElementById('carteError').style.display = "block";
            }
        }

        // Validation de la description
        const description = document.getElementById('description');
        if (!description.value.trim()) {
            valid = false;
            document.getElementById('descriptionError').textContent = "Veuillez entrer une description.";
            document.getElementById('descriptionError').style.display = "block";
        }

        // Empêcher la soumission si une erreur est détectée
        if (!valid) {
            event.preventDefault();
        }
    });

    // Réinitialisation des messages d'erreur
    function resetErrors() {
        const errorSpans = document.querySelectorAll('.error');
        errorSpans.forEach(span => {
            span.textContent = "";
            span.style.display = "none";
        });
    }
});
