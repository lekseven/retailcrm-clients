<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address implements ActivityLoggable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(max="255")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(max="255")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $address;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Client",
     *     inversedBy="addresses"
     * )
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getExcludedProperties(): array
    {
        return [
            'id',
            'client',
        ];
    }

    public function getParentEntity()
    {
        return $this->client;
    }
}
