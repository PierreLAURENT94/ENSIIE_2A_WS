<?php

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
	public $departureStationCity;
	public $arrivalStationCity;
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
	public $userMail;
	public $userPassword;
	public $outboundTrainId;
	public $returnTrainId;
	public $numberOfTickets;
	public $travelClass;
	public $flexible;
}

ini_set("soap.wsdl_cache_enabled", "0");

// initialize SOAP client and call web service function
$client = new SoapClient('http://127.0.0.1/server.php?wsdl', ['trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE]);

$trainSearch = new TrainSearch();
$trainSearch->departureCity = 'Bordeaux';
$trainSearch->arrivalCity = 'Paris';
$trainSearch->outboundDateTimeMin = '2023-12-31T11:00:00+02:00';
$trainSearch->outboundDateTimeMax = '2023-12-31T23:00:00+02:00';
$trainSearch->returnDateTimeMin = '2023-12-31T00:00:00+02:00';
$trainSearch->returnDateTimeMax = '2023-12-31T23:00:00+02:00';
$trainSearch->numberOfTickets = 5;
$trainSearch->travelClass = 'Standard';

$trainList = $client->trainsAvailable($trainSearch);
$outboundTrains = $client->trainsAvailable($trainSearch)->outboundTrains;
foreach ($outboundTrains as $train) {
	$departureDateTime = DateTime::createFromFormat(DateTime::ATOM, $train->departureDateTime);
	echo "• " . $train->company . " le " . $departureDateTime->format('d/m/Y à ') . $departureDateTime->format('H') . "h" . $departureDateTime->format('i') . " au prix de " . $train->priceStandard . " €<br><br>";
}

$user = new User();
$user->mail = 'pierre@test.rat';
$user->password = '123';

//$client->addUser($user);

var_dump($client->testUser($user));

$reservation = new Reservation();
$reservation->userMail = $user->mail;
$reservation->userPassword = $user->password;
$reservation->outboundTrainId =  $outboundTrains[0]->id;
$reservation->returnTrainId = null;
$reservation->numberOfTickets = 2;
$reservation->travelClass = "Business";
$reservation->flexible = false;

var_dump($client->makeReservation($reservation));