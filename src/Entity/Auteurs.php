<?php

namespace App\Entity;

use App\Repository\AuteursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AuteursRepository::class)
 */
class Auteurs
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
	 * @Assert\Length(min=2,max=255,minMessage="le nom doit faire minimum 2 caracteres",maxMessage="le nom doit faire maximum 255 caracteres")
	 */
	private $nom;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\Length(min=2,max=255,minMessage="le nom doit faire minimum 2 caracteres",maxMessage="le nom doit faire maximum 255 caracteres")
	 */
	private $prenom;

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

	public function getPrenom(): ?string
	{
		return $this->prenom;
	}

	public function setPrenom(?string $prenom): self
	{
		$this->prenom = $prenom;

		return $this;
	}
}