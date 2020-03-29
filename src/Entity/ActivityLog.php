<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ActivityLogRepository")
 */
class ActivityLog
{
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $entityId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="json", options={"charset": "utf8"})
     */
    private $changeSet = [];

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entityType;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getChangeSet(): ?array
    {
        return $this->changeSet;
    }

    public function setChangeSet(array $changeSet): self
    {
        $this->changeSet = $changeSet;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): self
    {
        $this->entityType = $entityType;

        return $this;
    }

    public function setEntity(int $entityId, string $entityType): self
    {
        $this->entityId = $entityId;
        $this->entityType = $entityType;

        return $this;
    }
}