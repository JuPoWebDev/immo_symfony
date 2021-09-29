<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail_customer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOf;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $firstname_customer;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $lastname_customer;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phone_customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMailCustomer(): ?string
    {
        return $this->mail_customer;
    }

    public function setMailCustomer(string $mail_customer): self
    {
        $this->mail_customer = $mail_customer;

        return $this;
    }

    public function getDateOf(): ?\DateTimeInterface
    {
        return $this->dateOf;
    }

    public function setDateOf(\DateTimeInterface $dateOf): self
    {
        $this->dateOf = $dateOf;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getFirstnameCustomer(): ?string
    {
        return $this->firstname_customer;
    }

    public function setFirstnameCustomer(string $firstname_customer): self
    {
        $this->firstname_customer = $firstname_customer;

        return $this;
    }

    public function getLastnameCustomer(): ?string
    {
        return $this->lastname_customer;
    }

    public function setLastnameCustomer(string $lastname_customer): self
    {
        $this->lastname_customer = $lastname_customer;

        return $this;
    }

    public function getPhoneCustomer(): ?string
    {
        return $this->phone_customer;
    }

    public function setPhoneCustomer(string $phone_customer): self
    {
        $this->phone_customer = $phone_customer;

        return $this;
    }
}
