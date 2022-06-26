<?php

namespace App\DataFixtures;

use App\Factory\SeasonFactory;
use App\Factory\TeamFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $teams = [
            0 => [
                'name'      => 'Newcastle United FC',
                'nickname'  => 'The Magpies',
                'foundedAt' => new \DateTime('09-12-1982')
            ],
            1 => [
                'name' => 'Manchester City',
                'nickname' => 'The Citizens',
                'foundedAt' => new \DateTime('1880')
            ]
        ];

        $seasons = [
            0 => [
                'year'      => '21/22',
                'current'   => false
            ],
            1 => [
                'year'      => '22/23',
                'current'   => true
            ]
        ];

        foreach ($teams as $team) {
            TeamFactory::createOne([
                'name'      => $team['name'],
                'nickname'  => $team['nickname'],
                'foundedAt' => $team['foundedAt']
            ]);
        }

        foreach ($seasons as $season) {
            SeasonFactory::createOne([
                'year'      => $season['year'],
                'current'   => $season['current']
            ]);
        }

        $manager->flush();
    }
}
