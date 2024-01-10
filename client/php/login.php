<!DOCTYPE html>
<html>
<head>
    <title>ENSIIE Connect - Connexion / Inscription</title>
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
    <?php
session_start();

require_once '../client.php';

$message = "";



if (isset($_POST['outboundTrainId']) && !isset($_POST['returnTrainId']) ) {
    $_SESSION['reservation'] = [
        'outboundTrainId' => $_POST['outboundTrainId'] ?? null,
        'returnTrainId' =>  null,
        'numberOfTickets' => $_POST['numberOfTickets'] ?? null,
        'travelClass' => $_POST['class'] ?? null,
        'flexible' => isset($_POST['flexible']) && $_POST['flexible'] == 'on'
    ];
}
else if(!isset($_POST['outboundTrainId']) && isset($_POST['returnTrainId']) ) {
    $_SESSION['reservation'] = [
        'outboundTrainId' => $_POST['returnTrainId'] ?? null,
        'returnTrainId' => null,
        'numberOfTickets' => $_POST['numberOfTickets'] ?? null,
        'travelClass' => $_POST['class'] ?? null,
        'flexible' => isset($_POST['flexible']) && $_POST['flexible'] == 'on'
    ];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $user->mail = $_POST['email'] ?? null;
    $user->password = $_POST['password'] ?? null;

    if (isset($_POST['login'])) {
      
        if ($client->testUser($user)) {
   
            $_SESSION['user'] = $user;
            $message = "Connexion réussie.";

                
                       if (isset($_SESSION['reservation'])) {
                        $reservationData = $_SESSION['reservation'];
                        $reservation = new Reservation();
                        $reservation->userMail = $user->mail;
                        $reservation->userPassword = $user->password;
                        $reservation->outboundTrainId = $reservationData['outboundTrainId'];
                        $reservation->returnTrainId = $reservationData['returnTrainId'];
                        $reservation->numberOfTickets = $reservationData['numberOfTickets'];
                        $reservation->travelClass = $reservationData['travelClass'];
                        $reservation->flexible = $reservationData['flexible'];
        
                 
                        if ($client->makeReservation($reservation)) {
                            header('Location: Rechercher_un_train.php?success=true');
                            exit;
                        } else {
                            $message = "Échec de la réservation.";
                        }
                    } else {
                  
                        $message = "Aucune donnée de réservation trouvée.";
                    }

        } else {
        
            $message = "Identifiants invalides.";
        }
    } elseif (isset($_POST['register'])) {
        try {
  
            $result = $client->addUser($user);
            if ($result) {
         
                $message = "Compte créé avec succès.";
            } else {
  
                $message = "Erreur lors de la création du compte.";
            }
        } catch (SoapFault $fault) {
       
            $message = "Adresse mail déjà existante.";
        }
    }
}
?>
<div class="centered-container">
<div class="login-card">
    <CENTER><h2>Connexion / Inscription</h2></CENTER>
    <form action="login.php" method="post">
        <div class="form-field">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="login" class="search-button">Se connecter</button>
        <button type="submit" name="register" class="search-button">Créer un compte</button>
    </form>
    <?php if (!empty($message)) : ?>
<div class="alert <?php echo ($message == "Connexion réussie." || $message == "Compte créé avec succès." ? 'alert-success' : 'alert-error'); ?>">
    <?php echo htmlspecialchars($message); ?>
</div>
    </div>
    </div>
<?php endif; ?>
</body>
</html>


