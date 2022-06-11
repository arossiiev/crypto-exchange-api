<?php

namespace App\Entity;

use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExchangeRateRepository::class)
 */
class ExchangeRate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AssetPair::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $assetPair;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $rate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetPair(): ?AssetPair
    {
        return $this->assetPair;
    }

    public function setAssetPair(?AssetPair $assetPair): self
    {
        $this->assetPair = $assetPair;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
