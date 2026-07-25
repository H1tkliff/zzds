<?php

namespace App\Entity;

use App\Repository\RankingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RankingRepository::class)]
class Ranking
{
    #[ORM\ManyToOne(targetEntity: Team::class)]
    private ?Team $team = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $points = null;
    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $snapshotDate = null;

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): void
    {
        $this->points = $points;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getSnapshotDate(): ?\DateTimeImmutable
    {
        return $this->snapshotDate;
    }

    public function setSnapshotDate(?\DateTimeImmutable $snapshotDate): void
    {
        $this->snapshotDate = $snapshotDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): void{
        $this->team = $team;
    }

}
