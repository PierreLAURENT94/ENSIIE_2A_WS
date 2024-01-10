<?php
session_start();
$success = isset($_GET['success']) && $_GET['success'] == 'true';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ENSIIE Connect - Accueil</title>
    <link rel="icon" href="../image/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
    <?php if ($success) : ?>
    <div class="alert alert-success" id="alertBox" style="margin: 0">
        La réservation a été effectuée avec succès !
        <button onclick="closeAlert()" class="close-btn">&times;</button>
    </div>
<?php endif; ?>
    <div class="background-image-container">
        <div class="form-container">
            <div class="search-container">
                <form action="searchTrains.php" method="post" class="search-form">
                    <div class="trip-type-container">
                        <input type="radio" id="oneWay" name="tripType" value="oneWay" checked>
                        <label for="oneWay">Aller simple</label>
                
                        <input type="radio" id="roundTrip" name="tripType" value="roundTrip">
                        <label for="roundTrip">Aller-retour</label>
                    </div>
                    <div class="form-group">
                        <label for="departureCity">De</label>
                        <select id="departureCity" name="departureCity" required>
                            <option value="Paris">Paris</option>
                            <option value="Marseille">Marseille</option>
                            <option value="Lyon">Lyon</option>
                            <option value="Toulouse">Toulouse</option>
                            <option value="Nice">Nice</option>
                            <option value="Nantes">Nantes</option>
                            <option value="Montpellier">Montpellier</option>
                            <option value="Strasbourg">Strasbourg</option>
                            <option value="Bordeaux">Bordeaux</option>
                            <option value="Lille">Lille</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="arrivalCity">À</label>
                        <select id="arrivalCity" name="arrivalCity" required>
                            <option value="Paris">Paris</option>
                            <option value="Marseille">Marseille</option>
                            <option value="Lyon">Lyon</option>
                            <option value="Toulouse">Toulouse</option>
                            <option value="Nice">Nice</option>
                            <option value="Nantes">Nantes</option>
                            <option value="Montpellier">Montpellier</option>
                            <option value="Strasbourg">Strasbourg</option>
                            <option value="Bordeaux">Bordeaux</option>
                            <option value="Lille">Lille</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="outboundDateTimeMin">Départ</label>
                        <input type="datetime-local" id="outboundDateTimeMin" name="outboundDateTimeMin" required>
                    </div>

                    <div class="form-group" id="returnFields">
                        <label for="returnDateTimeMin">Retour</label>
                        <input type="datetime-local" id="returnDateTimeMin" name="returnDateTimeMin">
                    </div>

                    <div class="form-group">
                        <label for="numberOfTickets">Passagers</label>
                        <input type="number" id="numberOfTickets" name="numberOfTickets" min="1" required>
                    </div>

                    <button type="submit" class="search-button">Chercher</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../script_js/script.js"></script>
    </body>
</html>
