<?php

namespace App\Factory;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Player>
 *
 * @method static Player|Proxy createOne(array $attributes = [])
 * @method static Player[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Player|Proxy find(object|array|mixed $criteria)
 * @method static Player|Proxy findOrCreate(array $attributes)
 * @method static Player|Proxy first(string $sortedField = 'id')
 * @method static Player|Proxy last(string $sortedField = 'id')
 * @method static Player|Proxy random(array $attributes = [])
 * @method static Player|Proxy randomOrCreate(array $attributes = [])
 * @method static Player[]|Proxy[] all()
 * @method static Player[]|Proxy[] findBy(array $attributes)
 * @method static Player[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Player[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PlayerRepository|RepositoryProxy repository()
 * @method Player|Proxy create(array|callable $attributes = [])
 */
final class PlayerFactory extends ModelFactory
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
            'name' => self::faker()->firstNameMale().' '.self::faker()->lastName(),
            'number' => self::faker()->numberBetween(1, 99),
            'team'  => TeamFactory::new(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Player $player): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Player::class;
    }
}
