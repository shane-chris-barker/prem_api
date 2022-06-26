<?php

namespace App\Factory;

use App\Entity\Season;
use App\Repository\SeasonRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Season>
 *
 * @method static Season|Proxy createOne(array $attributes = [])
 * @method static Season[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Season|Proxy find(object|array|mixed $criteria)
 * @method static Season|Proxy findOrCreate(array $attributes)
 * @method static Season|Proxy first(string $sortedField = 'id')
 * @method static Season|Proxy last(string $sortedField = 'id')
 * @method static Season|Proxy random(array $attributes = [])
 * @method static Season|Proxy randomOrCreate(array $attributes = [])
 * @method static Season[]|Proxy[] all()
 * @method static Season[]|Proxy[] findBy(array $attributes)
 * @method static Season[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Season[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static SeasonRepository|RepositoryProxy repository()
 * @method Season|Proxy create(array|callable $attributes = [])
 */
final class SeasonFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'year' => self::faker()->text(),
            'current' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Season $season): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Season::class;
    }
}
