<?php

namespace App\Entity;

use App\Repository\ChienRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChienRepository::class)
 */
class Chien
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank()
	 * @Assert\Length (
	 *
	 * min=2,
	 * max=255,
	 * minMessage="le nom doit faire {{ limit }} caractéres min .",
	 * maxMessage="le nom doit faire {{ limit }} caractéres max ."
	 * )
	 */
	private $nom;

	/**
	 * @ORM\Column(type="integer")
	 * @Assert\PositiveOrZero()
	 */
	private $age;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getNom(): ?string
	{
		return $this->nom;
	}

	public function setNom(string $nom): self
	{
		$this->nom = $nom;

		return $this;
	}

	public function getAge(): ?int
	{
		return $this->age;
	}

	public function setAge(int $age): self
	{
		$this->age = $age;

		return $this;
	}
}