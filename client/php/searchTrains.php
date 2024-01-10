<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ENSIIE Connect - Rechercher un train</title>
    <link rel="icon" href="../image/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="header">
        <img src="../image/logo.png" alt="ENSIE Connect Logo" id="logo">
        <nav class="navbar">
            <ul class="menu">
                <li><a href="Rechercher_un_train.php" class="active"><i class="fa fa-train" style="margin-right: 10px;"></i>Rechercher un train</a></li>
                <li><a href="Mes_reservations.php"><i class="fa fa-ticket-alt" style="margin-right: 10px;"></i>Mes réservations</a></li>                
            </ul>
        </nav>
    </header>

    <div class="train-container">
        <?php
        session_start();
        require_once '../client.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $departureCity = $_POST['departureCity'];
            $arrivalCity = $_POST['arrivalCity'];
            $outboundDateTimeMin = $_POST['outboundDateTimeMin'];
            $numberOfTickets = $_POST['numberOfTickets'];
            $isReturnChecked = isset($_POST['returnDateTimeMin']) && !empty($_POST['returnDateTimeMin']);
            
            $trainSearch = new TrainSearch();
            $trainSearch->departureCity = $departureCity;
            $trainSearch->arrivalCity = $arrivalCity;
            $trainSearch->outboundDateTimeMin = $outboundDateTimeMin;
            if ($isReturnChecked) {
                $trainSearch->returnDateTimeMin = $_POST['returnDateTimeMin'];
            }
            $trainSearch->numberOfTickets = $numberOfTickets;

            try {
                $trainList = $client->trainsAvailable($trainSearch);

                // Vérifiez si le résultat pour outboundTrains est un objet unique et convertissez-le en tableau
                if (!empty($trainList->outboundTrains) && !is_array($trainList->outboundTrains)) {
                    $trainList->outboundTrains = [$trainList->outboundTrains]; // Convertissez en tableau
                }

                if (!empty($trainList->outboundTrains)) {
                    echo "<h2>Trains Disponibles pour le départ</h2>";
                    foreach ($trainList->outboundTrains as $train) {
                        // Conversion des dates et heures en timestamps pour le calcul
                        $departureTimestamp = strtotime($train->departureDateTime);
                        $arrivalTimestamp = strtotime($train->arrivalDateTime);

                        // Calcul de la durée du trajet
                        $duration = $arrivalTimestamp - $departureTimestamp;
                        // Conversion de la durée en heures et minutes
                        $hours = floor($duration / 3600);
                        $minutes = floor(($duration / 60) % 60);

                        echo "<div class='train-card'>";
                        echo "<div class='train-times'>";
                        echo "<span class='departure-time'>" . date('H:i', $departureTimestamp) . "</span>";
                        echo "<div class='line'></div>";
                        echo "<span class='travel-time'>" . sprintf('%02d:%02d', $hours, $minutes) . " h</span>";
                        echo "<div class='line'></div>";
                        echo "<span class='arrival-time'>" . date('H:i', $arrivalTimestamp) . "</span>";
                        echo "</div>";
                        echo "<div class='train-locations'>";
                        echo "<span class='departure-station'>" . htmlspecialchars($train->departureCity) . " (" . htmlspecialchars($train->departureStation) . ")</span>";
                        echo "<span class='arrival-station'>" . htmlspecialchars($train->arrivalCity) . " (" . htmlspecialchars($train->arrivalStation) . ")</span>";
                        echo "</div>";
                        echo "<div class='train-action'>";
                        // Checkbox pour la sélection de la classe avec le prix
                        echo "<form id='trainForm' class='class-selection' action='login.php' method='post'>";
                        echo "<input type='hidden' name='outboundTrainId' value='" . htmlspecialchars($train->id) . "'>";
                        echo "<input type='hidden' name='numberOfTickets' value='" . $numberOfTickets . "'>";
                        echo "<label><input type='radio' name='class' value='Standard'> Standard&nbsp;<span class='price'>" . htmlspecialchars($train->priceStandard) . " €</span> </label>";
                        echo "<label><input type='radio' name='class' value='First'> Première&nbsp;<span class='price'>" . htmlspecialchars($train->priceFirst) . " €</span> </label>";
                        echo "<label><input type='radio' name='class' value='Business'> Affaires&nbsp;<span class='price'>" . htmlspecialchars($train->priceBusiness) . " €</span> </label>";
                        echo "<i class='fas fa-info-circle tooltip-icon' title='Prix indiqué par personne'></i>";
                        echo "<label><input type='checkbox' name='flexible'>Flexible</label>";
                        echo "<button type='submit'>Acheter</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<h2>Aucun train disponible pour le départ.</h2>";
                }

                 // Faites la même vérification pour returnTrains
                if (!empty($trainList->returnTrains) && !is_array($trainList->returnTrains)) {
                    $trainList->returnTrains = [$trainList->returnTrains]; // Convertissez en tableau
                }

                if ($isReturnChecked && !empty($trainList->returnTrains)) {
                    echo "<h2>Trains Disponibles pour le retour</h2>";
                    foreach ($trainList->returnTrains as $train) {
                       // Conversion des dates et heures en timestamps pour le calcul
                        $departureTimestamp = strtotime($train->departureDateTime);
                        $arrivalTimestamp = strtotime($train->arrivalDateTime);

                        // Calcul de la durée du trajet
                        $duration = $arrivalTimestamp - $departureTimestamp;
                        // Conversion de la durée en heures et minutes
                        $hours = floor($duration / 3600);
                        $minutes = floor(($duration / 60) % 60);

                        echo "<div class='train-card'>";
                        echo "<div class='train-times'>";
                        echo "<span class='departure-time'>" . date('H:i', $departureTimestamp) . "</span>";
                        echo "<div class='line'></div>";
                        echo "<span class='travel-time'>" . sprintf('%02d:%02d', $hours, $minutes) . " h</span>";
                        echo "<div class='line'></div>";
                        echo "<span class='arrival-time'>" . date('H:i', $arrivalTimestamp) . "</span>";
                        echo "</div>";
                        echo "<div class='train-locations'>";
                        echo "<span class='departure-station'>" . htmlspecialchars($train->departureCity) . " (" . htmlspecialchars($train->departureStation) . ")</span>";
                        echo "<span class='arrival-station'>" . htmlspecialchars($train->arrivalCity) . " (" . htmlspecialchars($train->arrivalStation) . ")</span>";
                        echo "</div>";
                        echo "<div class='train-action'>";
                        // Checkbox pour la sélection de la classe avec le prix
                        echo "<form id='trainForm' class='class-selection' action='login.php' method='post'>";
                        echo "<input type='hidden' name='returnTrainId' value='" . htmlspecialchars($train->id) . "'>";
                        echo "<input type='hidden' name='numberOfTickets' value='" . $numberOfTickets . "'>";
                        echo "<label><input type='radio' name='class' value='Standard'> Standard&nbsp;<span class='price'>" . htmlspecialchars($train->priceStandard) . " €</span> </label>";
                        echo "<label><input type='radio' name='class' value='First'> Première&nbsp;<span class='price'>" . htmlspecialchars($train->priceFirst) . " €</span> </label>";
                        echo "<label><input type='radio' name='class' value='Business'> Affaires&nbsp;<span class='price'>" . htmlspecialchars($train->priceBusiness) . " €</span> </label>";
                        echo "<i class='fas fa-info-circle tooltip-icon' title='Prix indiqué par personne'></i>";
                        echo "<label><input type='checkbox' name='flexible'>Flexible</label>";
                        echo "<button type='submit'>Acheter</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else if ($isReturnChecked) {
                    echo "<h2>Aucun train disponible pour le retour.</h2>";
                }
            } catch (SoapFault $fault) {
                echo "Erreur SOAP: " . htmlspecialchars($fault->faultcode) . ", " . htmlspecialchars($fault->faultstring);
            }
        }
        ?>
        <script>
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez tous les formulaires avec la classe 'class-selection'
    const forms = document.querySelectorAll('.class-selection');

    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const selectedClass = form.querySelector('input[name="class"]:checked');

            if (!selectedClass) {
                alert("Veuillez choisir un type de siège.");
                event.preventDefault(); // Empêcher la soumission du formulaire
            }
        });
    });
});
</script>
</body>
</html>
