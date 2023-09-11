<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Station;

class StationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $stations = [
            [
                "name" => "Gare du Nord",
                "city" => "Paris"
            ],
            [
                "name" => "Gare de Lyon",
                "city" => "Paris"
            ],
            [
                "name" => "Gare de Marseille-Saint-Charles",
                "city" => "Marseille"
            ],
            [
                "name" => "Gare de Lyon-Part-Dieu",
                "city" => "Lyon"
            ],
            [
                "name" => "Gare de Toulouse-Matabiau",
                "city" => "Toulouse"
            ],
            [
                "name" => "Gare de Nice-Ville",
                "city" => "Nice"
            ],
            [
                "name" => "Gare de Nantes",
                "city" => "Nantes"
            ],
            [
                "name" => "Gare de Montpellier-Saint-Roch",
                "city" => "Montpellier"
            ],
            [
                "name" => "Gare de Strasbourg-Ville",
                "city" => "Strasbourg"
            ],
            [
                "name" => "Gare de Bordeaux-Saint-Jean",
                "city" => "Bordeaux"
            ],
            [
                "name" => "Gare de Lille-Flandres",
                "city" => "Lille"
            ]
        ];

        foreach ($stations as $stationTour) {
            $station = new Station();
            $station
                ->setName($stationTour["name"])
                ->setCity($stationTour["city"]);
            $manager->persist($station);
        }

        $manager->flush();
    }
}