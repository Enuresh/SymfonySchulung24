<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min: 10)]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\Length(min: 30)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $isAccessible = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(min: 20)]
    private ?string $prerequisites = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual('now')]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(propertyPath: 'startAt')]
    private ?\DateTimeImmutable $endAt = null;

    /**
     * @var Collection<int, Volunteer>
     */
    #[ORM\OneToMany(targetEntity: Volunteer::class, mappedBy: 'event')]
    private Collection $volunteers;

    /**
     * @var Collection<int, Organization>
     */
    #[ORM\ManyToMany(targetEntity: Organization::class, mappedBy: 'events')]
    #[Assert\Valid]
    #[Assert\Count(min: 1)]
    private Collection $organizations;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\Valid]
    private ?Project $project = null;

    public function __construct()
    {
        $this->volunteers = new ArrayCollection();
        $this->organizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isAccessible(): ?bool
    {
        return $this->isAccessible;
    }

    public function setIsAccessible(bool $isAccessible): static
    {
        $this->isAccessible = $isAccessible;

        return $this;
    }

    public function getPrerequisites(): ?string
    {
        return $this->prerequisites;
    }

    public function setPrerequisites(?string $prerequisites): static
    {
        $this->prerequisites = $prerequisites;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection<int, Volunteer>
     */
    public function getVolunteers(): Collection
    {
        return $this->volunteers;
    }

    public function addVolunteer(Volunteer $volunteer): static
    {
        if (!$this->volunteers->contains($volunteer))
        {
            $this->volunteers->add($volunteer);
            $volunteer->setEvent($this);
        }

        return $this;
    }

    public function removeVolunteer(Volunteer $volunteer): static
    {
        if ($this->volunteers->removeElement($volunteer))
        {
            // set the owning side to null (unless already changed)
            if ($volunteer->getEvent() === $this)
            {
                $volunteer->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): static
    {
        if (!$this->organizations->contains($organization))
        {
            $this->organizations->add($organization);
            $organization->addEvent($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): static
    {
        if ($this->organizations->removeElement($organization))
        {
            $organization->removeEvent($this);
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
