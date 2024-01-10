function closeAlert() {
    var alertBox = document.getElementById("alertBox");
    if (alertBox) {
        alertBox.style.display = "none";
    }
}

document.addEventListener('DOMContentLoaded', () => {

    const departureCity = document.getElementById('departureCity');
    const arrivalCity = document.getElementById('arrivalCity');
    const searchForm = document.querySelector('.search-form');

    function validateCities() {
        if (departureCity.value === arrivalCity.value) {
            arrivalCity.setCustomValidity("La ville de départ et la ville d'arrivée ne peuvent pas être identiques.");
        } else {
            arrivalCity.setCustomValidity('');
        }
    }

    // Écoutez les changements dans les sélections de villes et validez
    departureCity.addEventListener('change', validateCities);
    arrivalCity.addEventListener('change', validateCities);

    searchForm.addEventListener('submit', function(event) {
        validateCities(); // Valider à nouveau lors de la soumission du formulaire

        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    }, false);

    validateCities(); // Valider initialement lors du chargement de la page


    const returnFields = document.getElementById('returnFields');
    const returnInput = document.getElementById('returnDateTimeMin');
    const oneWayRadio = document.getElementById('oneWay');
    const roundTripRadio = document.getElementById('roundTrip');

    // Fonction pour gérer l'affichage du champ de retour
    function toggleReturnFields() {
        // Affichez le champ retour si "Aller-retour" est sélectionné
        if (roundTripRadio.checked) {
            returnFields.style.display = 'flex';
            returnInput.disabled = false;
        } else {
            returnFields.style.display = 'none';
            returnInput.value = '';
            returnInput.disabled = true;

        }
    }
    
    // Écoutez l'événement de changement pour chaque bouton radio
    oneWayRadio.addEventListener('change', toggleReturnFields);
    roundTripRadio.addEventListener('change', toggleReturnFields);
    
    // Initialisation de l'affichage au chargement de la page
    toggleReturnFields();



    
    
});