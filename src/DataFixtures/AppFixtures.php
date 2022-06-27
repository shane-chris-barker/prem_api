<?php

namespace App\DataFixtures;

use App\Factory\PlayerFactory;
use App\Factory\SeasonFactory;
use App\Factory\TeamFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Create 10 teams
        $teams = TeamFactory::createMany(10);

        $seasons = [
            0 => [
                'year'      => '21/22',
                'isCurrent' => false
            ],
            1 => [
                'year'      => '22/23',
                'isCurrent'   => true
            ]
        ];

        // create 11 players and assign to the 10 teams
        foreach ($teams as $team) {
            PlayerFactory::new()->createMany(11, function() use ($team) {
                return [
                    'team' => $team
                ];
            });
        }

        foreach ($seasons as $season) {
            SeasonFactory::createOne([
                'year'      => $season['year'],
                'isCurrent' => $season['isCurrent']
            ]);
        }

        $manager->flush();
    }
}
