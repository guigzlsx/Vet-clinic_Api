<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

use Symfony\Component\Serializer\Attribute\Groups;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_ASSISTANT')", securityMessage: 'You are not allowed to get apointment'),
        new Post(security: "is_granted('ROLE_ASSISTANT')", securityMessage: 'You are not allowed to create this apointment'),
        new Get(security: "is_granted('ROLE_ASSISTANT')", securityMessage: 'You are not allowed to get this apointment'),
        new Patch(
            security: "is_granted('ROLE_ASSISTANT') and object.getStatus() != 'terminé' or is_granted('ROLE_VETERINAIRE')", 
            securityMessage: 'You are not allowed to edit this completed apointment'
        ),
        new Delete(security: "is_granted('ROLE_DIRECTOR')", securityMessage: 'You are not allowed to delete this apointment'),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    forceEager: false
)]
#[ApiFilter(DateFilter::class, properties: ['appointmentDate'])]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'partial', 'is_paid' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['appointmentDate'])]
#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{

    public const STATUS_SCHEDULED = 'programmé';
    public const STATUS_IN_PROGRESS = 'en cours';
    public const STATUS_COMPLETED = 'terminé';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: 'read')]

    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(groups: ['read'])]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(groups: ['read', 'write'])]

    private ?\DateTimeInterface $appointmentDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(groups: ['read', 'write'])]
    private ?string $reason = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ['read', 'write'])]
    #[MaxDepth(1)]

    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ['read', 'write'])]

    private ?User $assistant = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(groups: ['read', 'write'])]
    
    private ?User $veterinarian = null;

    #[ORM\Column]
    #[Groups(groups: ['read', 'write'])]
    private string $status = self::STATUS_SCHEDULED;

    /**
     * @var Collection<int, Treatment>
     */
    #[ORM\ManyToMany(targetEntity: Treatment::class, inversedBy: 'appointments')]
    #[Groups(groups: ['read', 'write'])]
    private Collection $treatment;

    #[ORM\Column]
    #[Groups(groups: ['read', 'write'])]
    private ?bool $is_paid = false;

    public function __construct()
    {
        $this->treatment = new ArrayCollection();
        $this->createdDate = new \DateTime(
            datetime: 'now',
            timezone: new \DateTimeZone('Europe/Paris')
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getAppointmentDate(): ?\DateTimeInterface
    {
        return $this->appointmentDate;
    }

    public function setAppointmentDate(\DateTimeInterface $appointmentDate): static
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        if ($assistant && !in_array('ROLE_ASSISTANT', $assistant->getRoles(), true)) {
            throw new \InvalidArgumentException("L'utilisateur sélectionné n'a pas le rôle d'assistant.");
        }

        $this->assistant = $assistant;
        return $this;
    }

    public function getVeterinarian(): ?User
    {
        return $this->veterinarian;
    }

    public function setVeterinarian(?User $veterinarian): static
    {
        if ($veterinarian && !in_array('ROLE_VETERINAIRE', $veterinarian->getRoles(), true)) {
            throw new \InvalidArgumentException("L'utilisateur sélectionné n'a pas le rôle de vétérinaire.");
        }
    
        $this->veterinarian = $veterinarian;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        if (!in_array($status, [
            self::STATUS_SCHEDULED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED
        ], true)) {
            throw new \InvalidArgumentException("Statut invalide.");
        }

        $this->status = $status;
        return $this;
    }

    /**
     * @return Collection<int, Treatment>
     */
    public function getTreatment(): Collection
    {
        return $this->treatment;
    }

    public function addTreatment(Treatment $treatment): static
    {
        if (!$this->treatment->contains($treatment)) {
            $this->treatment->add($treatment);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): static
    {
        $this->treatment->removeElement($treatment);

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->is_paid;
    }

    public function setIsPaid(bool $is_paid): static
    {
        $this->is_paid = $is_paid;

        return $this;
    }
}
