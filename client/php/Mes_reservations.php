<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ENSIIE Connect - Mes réservations</title>
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
                <li><a href="Rechercher_un_train.php"><i class="fa fa-train" style="margin-right: 10px;"></i>Rechercher un train</a></li>
                <li><a href="Mes_reservations.php" class="active"><i class="fa fa-ticket-alt" style="margin-right: 10px;"></i>Mes réservations</a></li>                
            </ul>
        </nav>
    </header>
<?php
require_once '../client.php';
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $reservations = $client->listReservation($user);
    $reservationDones = $reservations->ReservationDones;

    if (!is_array($reservationDones)) {
        $reservationDones = array($reservationDones);
    }

    echo "<div class='train-container'>";
    echo "<h2>Réservation de Train de $user->mail</h2>";
foreach ($reservationDones as $reservation) {
    echo "<div class='train-card'>";
    echo "<p><strong>Gare de départ:</strong> <span class ='station'> " . htmlspecialchars($reservation->departureStation) . "</p>";
    echo "<p><strong>Date de départ:</strong> <span class ='reservation-date'> " . htmlspecialchars(date('d M Y \à H:i', strtotime($reservation->departureDateTime))) . "</span></p>";
    echo "<p><strong>Gare de d'arrivée:</strong> <span class ='station'>" . htmlspecialchars($reservation->arrivalStation) . "</span></p>";
    echo "<p><strong>Nombre de billets:</strong> " . htmlspecialchars($reservation->numberOfTickets) . "</p>";
    echo "<p><strong>Classe de voyage:</strong> " . htmlspecialchars($reservation->travelClass) . "</p>";
    echo "<p><strong>Flexibilité:</strong> " . ($reservation->flexible ? 'Oui' : 'Non') . "</p>";
    echo "<p><strong>Prix total:</strong> <span class='price'>" . htmlspecialchars($reservation->totalPrice) . " € </span></p>";
    echo "</div>";
}
    echo "</div>";
} else {
    header('Location: login.php');
    exit;
}
?>
</body>
</html>