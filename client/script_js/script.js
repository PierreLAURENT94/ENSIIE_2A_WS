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


    departureCity.addEventListener('change', validateCities);
    arrivalCity.addEventListener('change', validateCities);

    searchForm.addEventListener('submit', function(event) {
        validateCities(); 

        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    }, false);

    validateCities();


    const returnFields = document.getElementById('returnFields');
    const returnInput = document.getElementById('returnDateTimeMin');
    const oneWayRadio = document.getElementById('oneWay');
    const roundTripRadio = document.getElementById('roundTrip');

  
    function toggleReturnFields() {

        if (roundTripRadio.checked) {
            returnFields.style.display = 'flex';
            returnInput.disabled = false;
        } else {
            returnFields.style.display = 'none';
            returnInput.value = '';
            returnInput.disabled = true;

        }
    }
    
 
    oneWayRadio.addEventListener('change', toggleReturnFields);
    roundTripRadio.addEventListener('change', toggleReturnFields);
    

    toggleReturnFields();



    
    
});