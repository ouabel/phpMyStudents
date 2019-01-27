<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation\Exclude;
use Hateoas\Configuration\Annotation as Hateoas;
use App\Entity\Student;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 * @Hateoas\Relation(
 *      "students",
 *      href = @Hateoas\Route(
 *          "api_department_students",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 */
class Department
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
     *      maxMessage = "Name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer", length=10)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Capacity cannot be longer than {{ limit }} characters"
     * )
     */
    private $capacity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="department", cascade={"remove"})
     * @Assert\NotBlank
     * @Exclude
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
