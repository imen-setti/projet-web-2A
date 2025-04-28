document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la date actuelle
    const today = new Date();
    const day = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Les mois commencent à 0
    const year = today.getFullYear();
    
    // Formater la date au format YYYY-MM-DD (format requis pour <input type="date">)
    const formattedDate = `${year}-${month}-${day}`;
    
    // Définir la date actuelle dans le champ 'daterec'
    const daterec = document.getElementById('daterec');
    daterec.value = formattedDate;
    
    // Interdire la sélection de dates futures
    daterec.setAttribute('max', formattedDate);

    const form = document.querySelector('.custom-form');
    
    form.addEventListener('submit', function(event) {
        let valid = true;
        
        // Réinitialiser les messages d'erreur
        resetErrors();

        // Validation de l'email
        const email = document.getElementById('email');
        if (!email.value || !validateEmail(email.value)) {
            valid = false;
            document.getElementById('emailError').textContent = "Veuillez entrer une adresse email valide.";
            document.getElementById('emailError').style.display = "block";
        }

        // Validation du sujet
        const sujet = document.getElementById('sujet');
        if (!sujet.value) {
            valid = false;
            document.getElementById('subjectError').textContent = "Veuillez entrer un sujet.";
            document.getElementById('subjectError').style.display = "block";
        }

        // Validation de la description
        const descrip = document.getElementById('descrip');
        if (!descrip.value) {
            valid = false;
            document.getElementById('descriptionError').textContent = "Veuillez entrer une description.";
            document.getElementById('descriptionError').style.display = "block";
        }

        // Validation de la date
        const daterec = document.getElementById('daterec');
        if (!daterec.value) {
            valid = false;
            document.getElementById('dateError').textContent = "Veuillez sélectionner une date.";
            document.getElementById('dateError').style.display = "block";
        }

        // Si la validation échoue, empêcher la soumission du formulaire
        if (!valid) {
            event.preventDefault();
        }
    });

    // Fonction pour réinitialiser les messages d'erreur
    function resetErrors() {
        const errorSpans = document.querySelectorAll('.error');
        errorSpans.forEach(span => {
            span.textContent = "";
            span.style.display = "none";
        });
    }

    // Validation de l'email (expression régulière)
    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return re.test(email);
    }
});
