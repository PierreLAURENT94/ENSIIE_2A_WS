<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Train;
use DateInterval;
use DateTime;

class TrainFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $stations = ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Montpellier", "Strasbourg", "Bordeaux", "Lille"];

        foreach ($stations as $departureStation) {
            foreach ($stations as $arrivalStation) {
                if ($departureStation != $arrivalStation) {
                    switch ($_ENV['COMPANY']) {
                        case 'TGV INOUI':
                            $duration = DateInterval::createFromDateString(rand(30, 360) . " minutes");

                            $departureTrain1 = new DateTime();
                            $departureTrain1->setTime(rand(8, 11), rand(0, 59));
                            $arrivalTrain1 = clone $departureTrain1;
                            $arrivalTrain1->add($duration);
                            $priceFirstTrain1 = rand(5000, 15000);
                            $train1 = new Train;
                            $train1
                                ->setDepartureStation($departureStation)
                                ->setDepartureDateTime($departureTrain1)
                                ->setArrivalStation($arrivalStation)
                                ->setArrivalDateTime($arrivalTrain1)
                                ->setSeatsAvailableBusiness(rand(0, 25))
                                ->setPriceBusiness(rand(30000, 90000) / 100)
                                ->setSeatsAvailableFirst(rand(0, 150))
                                ->setPriceFirst($priceFirstTrain1 / 100)
                                ->setSeatsAvailableStandard(rand(0, 325))
                                ->setPriceStandard(rand(3500, min(10500, $priceFirstTrain1)) / 100);
                            $manager->persist($train1);

                            $departureTrain2 = new DateTime();
                            $departureTrain2->setTime(rand(12, 15), rand(0, 59));
                            $arrivalTrain2 = clone $departureTrain2;
                            $arrivalTrain2->add($duration);
                            $priceFirstTrain2 = rand(5000, 15000);
                            $train2 = new Train;
                            $train2
                                ->setDepartureStation($departureStation)
                                ->setDepartureDateTime($departureTrain2)
                                ->setArrivalStation($arrivalStation)
                                ->setArrivalDateTime($arrivalTrain2)
                                ->setSeatsAvailableBusiness(rand(0, 25))
                                ->setPriceBusiness(rand(30000, 90000) / 100)
                                ->setSeatsAvailableFirst(rand(0, 150))
                                ->setPriceFirst($priceFirstTrain2 / 100)
                                ->setSeatsAvailableStandard(rand(0, 325))
                                ->setPriceStandard(rand(3500, min(10500, $priceFirstTrain2)) / 100);
                            $manager->persist($train2);

                            $departureTrain3 = new DateTime();
                            $departureTrain3->setTime(rand(15, 18), rand(0, 59));
                            $arrivalTrain3 = clone $departureTrain3;
                            $arrivalTrain3->add($duration);
                            $priceFirstTrain3 = rand(5000, 15000);
                            $train3 = new Train;
                            $train3
                                ->setDepartureStation($departureStation)
                                ->setDepartureDateTime($departureTrain3)
                                ->setArrivalStation($arrivalStation)
                                ->setArrivalDateTime($arrivalTrain3)
                                ->setSeatsAvailableBusiness(rand(0, 25))
                                ->setPriceBusiness(rand(30000, 90000) / 100)
                                ->setSeatsAvailableFirst(rand(0, 150))
                                ->setPriceFirst($priceFirstTrain3 / 100)
                                ->setSeatsAvailableStandard(rand(0, 325))
                                ->setPriceStandard(rand(3500, min(10500, $priceFirstTrain3)) / 100);
                            $manager->persist($train3);
                            break;
                    }
                }
            }
        }

        $manager->flush();
    }
}
