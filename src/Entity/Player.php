<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: PlayerRepository::class)]

#[ApiResource(
    denormalizationContext: ['groups' => ['player:write']],
    normalizationContext: ['groups' => ['player:read']]
)]
#[ApiFilter(SearchFilter::class, properties: ['team.name' => 'partial', 'team' => 'exact'] )]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('player:read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['player:read', 'team:item:get', 'player:write', 'team:write'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['player:read', 'team:item:get', 'player:write', 'team:write'])]
    private $number;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['player:read', 'player:write'])]
    private $team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }
}
