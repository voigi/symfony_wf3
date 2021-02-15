<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $titre;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $soustitre;

	/**
	 * @ORM\Column(type="text")
	 */
	private $contenu;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $publie;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $dateDePublication;

	/**
	 * @ORM\ManyToOne(targetEntity=Auteurs::class, inversedBy="articles",fetch="EAGER")
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	private $auteur;

	/**
	 * @ORM\ManyToMany(targetEntity=Categories::class, inversedBy="articles")
	 */
	private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="articles")
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     */
    private $user;

	public function __construct()
                     	{
                     		$this->categories = new ArrayCollection();
                     		$this->commentaires = new ArrayCollection();
                     	}

	public function getId(): ?int
                     	{
                     		return $this->id;
                     	}

	public function getTitre(): ?string
                     	{
                     		return $this->titre;
                     	}

	public function setTitre(string $titre): self
                     	{
                     		$this->titre = $titre;
                     
                     		return $this;
                     	}

	public function getSoustitre(): ?string
                     	{
                     		return $this->soustitre;
                     	}

	public function setSoustitre(?string $soustitre): self
                     	{
                     		$this->soustitre = $soustitre;
                     
                     		return $this;
                     	}

	public function getContenu(): ?string
                     	{
                     		return $this->contenu;
                     	}

	public function setContenu(string $contenu): self
                     	{
                     		$this->contenu = $contenu;
                     
                     		return $this;
                     	}

	public function getPublie(): ?bool
                     	{
                     		return $this->publie;
                     	}

	public function setPublie(bool $publie): self
                     	{
                     		$this->publie = $publie;
                     
                     		return $this;
                     	}

	public function getDateDePublication(): ?\DateTimeInterface
                     	{
                     		return $this->dateDePublication;
                     	}

	public function setDateDePublication(\DateTimeInterface $dateDePublication): self
                     	{
                     		$this->dateDePublication = $dateDePublication;
                     
                     		return $this;
                     	}

	public function getAuteur(): ?Auteurs
                     	{
                     		return $this->auteur;
                     	}

	public function setAuteur(?Auteurs $auteur): self
                     	{
                     		$this->auteur = $auteur;
                     
                     		return $this;
                     	}

	/**
	 * @return Collection|Categories[]
	 */
	public function getCategories(): Collection
                     	{
                     		return $this->categories;
                     	}

	public function addCategory(Categories $category): self
                     	{
                     		if (!$this->categories->contains($category)) {
                     			$this->categories[] = $category;
                     		}
                     
                     		return $this;
                     	}

	public function removeCategory(Categories $category): self
                     	{
                     		$this->categories->removeElement($category);
                     
                     		return $this;
                     	}

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setArticles($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticles() === $this) {
                $commentaire->setArticles(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}