<?php

namespace App\Entity;

use App\Repository\AuteursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
	 * @Assert\Length(min=2,max=255,minMessage="le prenom doit faire minimum 2 caracteres",maxMessage="le nom doit faire maximum 255 caracteres")
	 */
	private $prenom;

	/**
	 * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="auteur")
	 */
	private $articles;

	public function __construct()
	{
		$this->articles = new ArrayCollection();
	}

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

	/**
	 * @return Collection|Articles[]
	 */
	public function getArticles(): Collection
	{
		return $this->articles;
	}

	public function addArticle(Articles $article): self
	{
		if (!$this->articles->contains($article)) {
			$this->articles[] = $article;
			$article->setAuteur($this);
		}

		return $this;
	}

	public function removeArticle(Articles $article): self
	{
		if ($this->articles->removeElement($article)) {
			// set the owning side to null (unless already changed)
			if ($article->getAuteur() === $this) {
				$article->setAuteur(null);
			}
		}

		return $this;
	}
}