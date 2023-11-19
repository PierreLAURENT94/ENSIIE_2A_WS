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

$server->addFunction('trainsAvailable');

// start handling requests
$server->handle();