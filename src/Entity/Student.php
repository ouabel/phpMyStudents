<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Department;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "First name cannot be longer than {{ limit }} characters"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Last name cannot be longer than {{ limit }} characters"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer", length=10, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Student number cannot be longer than {{ limit }} characters"
     * )
     */
    private $numEtud;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="students")
     * @Assert\NotBlank
     * @Exclude
     */
    private $department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNumEtud(): ?int
    {
        return $this->numEtud;
    }

    public function setNumEtud(int $numEtud): self
    {
        $this->numEtud = $numEtud;

        return $this;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;    
    }
}
