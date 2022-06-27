<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource(
    collectionOperations: ['GET', 'POST'],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => [
                    'team:item:get'
                ]
            ]
        ],
        'PUT'
    ],
    attributes: ['pagination_items_per_page' => 10],
    denormalizationContext: ['groups' => ['team:write']],
    formats: ['jsonld', 'json', 'html', 'jsonhal', 'csv' => ['text/csv']],
    normalizationContext: ['groups' => ['team:read']]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'] )]
#[ApiFilter(RangeFilter::class, properties: ['foundedAt'] )]
#[ApiFilter(PropertyFilter::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['team:read', 'team:write', 'player:read', 'player:write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        [
            'min'           => 1,
            'max'           => 255,
            'maxMessage'    => 'A team name can only be a maximum of 255 characters'
        ]
    )]
    private $name;

    #[ORM\Column(type: 'date')]
    #[Groups(['team:read', 'team:write', 'player:write'])]
    private $foundedAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['team:read', 'team:write', 'player.write'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        [
            'min'           => 1,
            'max'           => 255,
            'maxMessage'    => 'A team nickname can only be a maximum of 255 characters'
        ]
    )]
    private $nickname;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Player::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['team:read', 'team:item:get', 'team:write'])]
    #[ApiSubresource]
    private $players;

    public function __construct(string $name = null) {
        $this->name = $name;
        $this->players = new ArrayCollection();
    }

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

    #[Groups(['team:read'])]
    public function getShortName(): ?string
    {
        $name = $this->getName();

        $nameParts = explode(' ', $name);
        $shortNameString = "";

        foreach ($nameParts as $namePart) {
            if ($namePart !== 'FC') {
                $shortNameString .= $namePart[0];
            } else {
                $shortNameString .= 'FC';
            }
        }

        return $shortNameString;

    }

    public function getFoundedAt(): ?\DateTimeInterface
    {
        return $this->foundedAt;
    }

    public function setFoundedAt(\DateTimeInterface $foundedAt): self
    {
        $this->foundedAt = $foundedAt;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }
}
