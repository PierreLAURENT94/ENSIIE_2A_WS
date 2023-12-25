<?php
class RestClient
{

	private $host;

	public function __construct($host)
	{
		$this->host = $host;
	}

	public function demo()
	{
		try {
			// Test pour récupérer toutes les stations
			$stations = self::fetchStations(1, "", "");
			foreach ($stations as $station) {
				$id = $station['id'];
				$name = $station['name'];
				$city = $station['city'];
				echo "ID : $id, Nom : $name, Ville : $city\n";
			}
		} catch (Exception $e) {
			echo $e->getMessage() . "\n";
		}

		try {
			// Test pour récupérer les informations d'une station par son ID
			$station = self::fetchStationById(2);
			echo "ID : " . $station['id'] . "\n";
			echo "Nom : " . $station['name'] . "\n";
			echo "Ville : " . $station['city'] . "\n";
		} catch (Exception $e) {
			echo $e->getMessage() . "\n";
		}

		$params = ['page' => '1'];
		try {
			// Test pour récupérer toutes les informations sur les trains en fonction des filtres
			$trains = self::fetchTrains($params);
			foreach ($trains as $train) {
				// Extraction des informations pertinentes sur chaque train
				$id = $train['id'];
				$departureStation = $train['departureStation'];
				$arrivalStation = $train['arrivalStation'];
				$departureDateTime = $train['departureDateTime'];
				$arrivalDateTime = $train['arrivalDateTime'];
				$seatsAvailableBusiness = $train['seatsAvailableBusiness'];
				$priceBusiness = $train['priceBusiness'];
				$seatsAvailableFirst = $train['seatsAvailableFirst'];
				$priceFirst = $train['priceFirst'];
				$seatsAvailableStandard = $train['seatsAvailableStandard'];
				$priceStandard = $train['priceStandard'];

				// Affichage des informations du train
				echo "ID du train : $id\n";
				echo "Départ : {$departureStation['name']}, {$departureStation['city']} à $departureDateTime\n";
				echo "Arrivée : {$arrivalStation['name']}, {$arrivalStation['city']} à $arrivalDateTime\n";
				echo "Places Business disponibles : $seatsAvailableBusiness à $priceBusiness\n";
				echo "Places de première classe disponibles : $seatsAvailableFirst à $priceFirst\n";
				echo "Places Standard disponibles : $seatsAvailableStandard à $priceStandard\n";
				echo "-----------------------------------------------------------\n";
			}
		} catch (Exception $e) {
			echo $e->getMessage() . "\n";
		}

		try {
			// Test pour récupérer toutes les informations sur un train par son ID
			$trainDetails = self::fetchTrainById("1");
			echo "Nom de la gare de départ : " . $trainDetails['departureStationName'] . "\n";
			echo "Ville de départ : " . $trainDetails['departureCity'] . "\n";
			echo "Nom de la gare d'arrivée : " . $trainDetails['arrivalStationName'] . "\n";
			echo "Ville d'arrivée : " . $trainDetails['arrivalCity'] . "\n";
			echo "Date et heure de départ : " . $trainDetails['departureDateTime'] . "\n";
			echo "Date et heure d'arrivée : " . $trainDetails['arrivalDateTime'] . "\n";
			echo "Places disponibles (Business) : " . $trainDetails['seatsAvailableBusiness'] . "\n";
			echo "Prix (Business) : " . $trainDetails['priceBusiness'] . "\n";
			echo "Places disponibles (Première classe) : " . $trainDetails['seatsAvailableFirst'] . "\n";
			echo "Prix (Première classe) : " . $trainDetails['priceFirst'] . "\n";
			echo "Places disponibles (Standard) : " . $trainDetails['seatsAvailableStandard'] . "\n";
			echo "Prix (Standard) : " . $trainDetails['priceStandard'] . "\n";
		} catch (Exception $e) {
			echo $e->getMessage() . "\n";
		}

		try {
			// Test pour mettre à jour le nombre de places pour chaque type de siège d'un train
			self::updateSeatsForTrain("1", 5, null, null);
		} catch (Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}

	// Fonction pour récupérer toutes les stations en fonction d'un nom ou d'une ville
	public function fetchStations($page, $name, $city)
	{
		$url = $this->host . "stations?page=$page&name=$name&city=$city";
		$jsonData = self::makeRequest($url);
		$jsonObject = json_decode($jsonData, true);
		return $jsonObject['hydra:member'];
	}

	// Fonction pour récupérer toutes les informations sur une station par son ID
	public function fetchStationById($id)
	{
		$url = $this->host . "stations/$id";
		$jsonData = self::makeRequest($url);
		$jsonObject = json_decode($jsonData, true);

		$stationId = $jsonObject['id'];
		$name = $jsonObject['name'];
		$city = $jsonObject['city'];

		return ['id' => $stationId, 'name' => $name, 'city' => $city];
	}

	// Fonction pour récupérer toutes les informations sur tous les trains en fonction des filtres
	public function fetchTrains($parameters)
	{
		$url = $this->host . "trains?" . http_build_query($parameters);
		$jsonData = self::makeRequest($url);
		$jsonObject = json_decode($jsonData, true);
		return $jsonObject['hydra:member'];
	}

	// Fonction pour récupérer toutes les informations sur un train par son ID
	public function fetchTrainById($id)
	{
		$url = $this->host . "trains/$id";
		$jsonData = self::makeRequest($url);
		$jsonObject = json_decode($jsonData, true);

		$departureStation = $jsonObject['departureStation'];
		$arrivalStation = $jsonObject['arrivalStation'];
		$departureDateTime = $jsonObject['departureDateTime'];
		$arrivalDateTime = $jsonObject['arrivalDateTime'];
		$seatsAvailableBusiness = $jsonObject['seatsAvailableBusiness'];
		$priceBusiness = $jsonObject['priceBusiness'];
		$seatsAvailableFirst = $jsonObject['seatsAvailableFirst'];
		$priceFirst = $jsonObject['priceFirst'];
		$seatsAvailableStandard = $jsonObject['seatsAvailableStandard'];
		$priceStandard = $jsonObject['priceStandard'];

		return [
			'departureStationName' => $departureStation['name'],
			'departureCity' => $departureStation['city'],
			'arrivalStationName' => $arrivalStation['name'],
			'arrivalCity' => $arrivalStation['city'],
			'departureDateTime' => $departureDateTime,
			'arrivalDateTime' => $arrivalDateTime,
			'seatsAvailableBusiness' => $seatsAvailableBusiness,
			'priceBusiness' => $priceBusiness,
			'seatsAvailableFirst' => $seatsAvailableFirst,
			'priceFirst' => $priceFirst,
			'seatsAvailableStandard' => $seatsAvailableStandard,
			'priceStandard' => $priceStandard,
		];
	}

	// Fonction pour mettre à jour le nombre de places pour chaque type de siège d'un train
	public function updateSeatsForTrain($id, $seatsAvailableStandard, $seatsAvailableFirst, $seatsAvailableBusiness)
	{
		$url = $this->host . "trains/$id";

		$requestBody = [];
		$seatsUpdated = '';

		if ($seatsAvailableStandard !== null) {
			$requestBody['seatsAvailableStandard'] = $seatsAvailableStandard;
			$seatsUpdated .= 'Standard ';
		}

		if ($seatsAvailableFirst !== null) {
			$requestBody['seatsAvailableFirst'] = $seatsAvailableFirst;
			$seatsUpdated .= 'First ';
		}

		if ($seatsAvailableBusiness !== null) {
			$requestBody['seatsAvailableBusiness'] = $seatsAvailableBusiness;
			$seatsUpdated .= 'Business ';
		}

		$requestOptions = [
			'http' => [
				'method' => 'PATCH',
				'header' => "Content-type: application/merge-patch+json; charset=utf-8",
				'content' => json_encode($requestBody),
			],
		];

		$context = stream_context_create($requestOptions);
		$response = file_get_contents($url, false, $context);

		if ($response === false) {
			throw new Exception("Échec de la mise à jour des places pour le train ID : $id");
		}

		echo $seatsUpdated . "places mises à jour avec succès pour le train ID : $id\n";
	}

	// Fonction pour effectuer une requête HTTP et récupérer les données JSON
	private function makeRequest($url)
	{
		$jsonData = file_get_contents($url);

		if ($jsonData === false) {
			throw new Exception("Impossible de récupérer les données depuis $url");
		}

		return $jsonData;
	}
}

// Connexion à la base de données
$sql = new mysqli("127.0.0.1", "root", "", "soap");

// Utilisation du constructeur avec l'URL de l'hôte
$TGVinOui = new RestClient("http://127.0.0.1:8005/");
// Exécution de la demo
// $TGVinOui->demo();

// turn off WSDL caching
ini_set("soap.wsdl_cache_enabled", "0");

// initialize SOAP Server
$server = new SoapServer("test.wsdl", [
	'classmap' => [
		'trainSearch' => 'TrainSearch',
	]
]);

class TrainSearch
{
	public $departureCity;
	public $arrivalCity;
	public $outboundDateTimeMin;
	public $outboundDateTimeMax;
	public $returnDateTimeMin;
	public $returnDateTimeMax;
	public $numberOfTickets;
	public $travelClass;
}

class Train
{
	public $id;
	public $departureCity;
	public $arrivalCity;
	public $departureStation;
	public $arrivalStation;
	public $departureDateTime;
	public $arrivalDateTime;
	public $seatsAvailableBusiness;
	public $priceBusiness;
	public $seatsAvailableFirst;
	public $priceFirst;
	public $seatsAvailableStandard;
	public $priceStandard;
	public $company;
}

class TrainList
{
	public $outboundTrains;
	public $returnTrains;
}

class User
{
	public $mail;
	public $password;
}

class Reservation
{
	public $user;
	public $outboundTrainId;
	public $returnTrainId;
	public $numberOfTickets;
	public $travelClass;
	public $flexible;
}

function trainsAvailable($trainSearch)
{
	global $TGVinOui;
	$departureStationId = $TGVinOui->fetchStations(1, "", $trainSearch->departureCity)[0]['id'];
	$arrivalStationId = $TGVinOui->fetchStations(1, "", $trainSearch->arrivalCity)[0]['id'];

	$outboundTrains = [];

	$params = [
		'page' => 1,
		'departureStation.id' => $departureStationId,
		'arrivalStation.id' => $arrivalStationId,
		'departureDateTime[after]' => $trainSearch->outboundDateTimeMin,
		'departureDateTime[before]' => $trainSearch->outboundDateTimeMax,
		'arrivalDateTime[after]' => $trainSearch->returnDateTimeMin,
		'arrivalDateTime[before]' => $trainSearch->returnDateTimeMax,
	];

	switch ($trainSearch->travelClass) {
		case 'Business':
			$params['seatsAvailableBusiness[gte]'] = $trainSearch->numberOfTickets;
			break;
		case 'First':
			$params['seatsAvailableFirst[gte]'] = $trainSearch->numberOfTickets;
			break;
		case 'Standard':
			$params['seatsAvailableStandard[gte]'] = $trainSearch->numberOfTickets;
			break;
	}

	$trainsRest = $TGVinOui->fetchTrains($params);
	foreach ($trainsRest as $trainRest) {
		$train = new Train();
		$train->id = $trainRest['id'];
		$train->departureCity = $trainRest['departureStation']['city'];
		$train->arrivalCity = $trainRest['arrivalStation']['city'];
		$train->departureStation = $trainRest['departureStation']['name'];
		$train->arrivalStation = $trainRest['arrivalStation']['name'];
		$train->departureDateTime = $trainRest['departureDateTime'];
		$train->arrivalDateTime = $trainRest['arrivalDateTime'];
		$train->seatsAvailableBusiness = $trainRest['seatsAvailableBusiness'];
		$train->priceBusiness = $trainRest['priceBusiness'];
		$train->seatsAvailableFirst = $trainRest['seatsAvailableFirst'];
		$train->priceFirst = $trainRest['priceFirst'];
		$train->seatsAvailableStandard = $trainRest['seatsAvailableStandard'];
		$train->priceStandard = $trainRest['priceStandard'];
		$train->company = "TGV inOui";
		$outboundTrains[] = $train;
	}

	$trainList = new TrainList();
	$trainList->outboundTrains = $outboundTrains;

	return $trainList;
}

function addUser($user)
{
	global $sql;
	$insertUser = $sql->prepare("INSERT INTO users (mail, password) VALUES (?, ?)");
	$insertUser->bind_param("ss", $user->mail, $user->password);
	$insertUser->execute();

	return true;
}

function testUser($user)
{
	global $sql;
	$selectUser = $sql->prepare("SELECT * FROM users WHERE mail = ? AND password = ?");
	$selectUser->bind_param("ss", $user->mail, $user->password);
	$selectUser->execute();
	$selectUser->store_result();

	if ($selectUser->num_rows > 0) {
		$selectUser->close();
		return true;
	} else {
		$selectUser->close();
		return false;
	}
}

function makeReservation($reservation)
{
	global $sql;
	global $TGVinOui;
	$selectUser = $sql->prepare("SELECT id FROM users WHERE mail = ? AND password = ?");
	$selectUser->bind_param("ss", $reservation->user->mail, $reservation->user->password);
	$selectUser->execute();
	$selectUser->store_result();

	$outboundTrain = $TGVinOui->fetchTrainById($reservation->outboundTrainId);
	$returnTrain = null;

	if ($reservation->returnTrainId != null) {
		$returnTrain = $TGVinOui->fetchTrainById($reservation->returnTrainId);
	}

	if ($selectUser->num_rows > 0) {
		$selectUser->bind_result($userId);
		$TGVinOui->fetchTrainById($reservation->user);

		$returnDate = $returnTrain !== null ? $returnTrain['departureDateTime'] : null;

		switch ($reservation->travelClass) {
			case 'Business':
				$totalPrice = $outboundTrain['priceBusiness'] * $reservation->numberOfTickets;
				break;
			case 'First':
				$totalPrice = $outboundTrain['priceFirst'] * $reservation->numberOfTickets;
				break;
			case 'Standard':
				$totalPrice = $outboundTrain['priceStandard'] * $reservation->numberOfTickets;
				break;
			default:
				return false;
		}
		if ($returnDate) {
			switch ($reservation->travelClass) {
				case 'Business':
					$totalPrice += $returnTrain['priceBusiness'] * $reservation->numberOfTickets;
					break;
				case 'First':
					$totalPrice += $returnTrain['priceFirst'] * $reservation->numberOfTickets;
					break;
				case 'Standard':
					$totalPrice += $returnTrain['priceStandard'] * $reservation->numberOfTickets;
					break;
				default:
					return false;
			} 
		}

		if ($reservation->flexible) {
			$totalPrice *= 1.2;
		}

		$insertReservation = $sql->prepare("INSERT INTO reservation (user_id, departure_station, arrival_station, departure_date, return_date, number_of_tickets, travel_class, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
		if ($reservation->returnTrain)
			$insertReservation->bind_param(
				"issssisd",
				$userId,
				$outboundTrain['departureStationName'],
				$outboundTrain['arrivalStationName'],
				$outboundTrain['departureDateTime'],
				$returnDate,
				$reservation->numberOfTickets,
				$reservation->travelClass,
				$totalPrice
			);

	} else {
		return false;
	}


	return true;
}

$server->addFunction('trainsAvailable');
$server->addFunction('addUser');
$server->addFunction('testUser');

// start handling requests
$server->handle();