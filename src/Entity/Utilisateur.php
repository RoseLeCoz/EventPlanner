<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $nom;

    #[ORM\Column(length: 100)]
    private ?string $prenom;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'utilisateur')]
    private Collection $participation;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'utilisateur')]
    private Collection $lesCommentaires;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'leUtilisateur')]
    private Collection $lesEvenements;

    public function __construct()
    {
        $this->participation = new ArrayCollection();
        $this->lesCommentaires = new ArrayCollection();
        $this->lesEvenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNom(): ?String
    {
        return $this->nom;
    }

    public function setNom(String $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?String
    {
        return $this->prenom;
    }

    public function setPrenom(String $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipation(): Collection
    {
        return $this->participation;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participation->contains($participation)) {
            $this->participation->add($participation);
            $participation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participation->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUtilisateur() === $this) {
                $participation->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getLesCommentaires(): Collection
    {
        return $this->lesCommentaires;
    }

    public function addLesCommentaire(Commentaire $lesCommentaire): static
    {
        if (!$this->lesCommentaires->contains($lesCommentaire)) {
            $this->lesCommentaires->add($lesCommentaire);
            $lesCommentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeLesCommentaire(Commentaire $lesCommentaire): static
    {
        if ($this->lesCommentaires->removeElement($lesCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($lesCommentaire->getUtilisateur() === $this) {
                $lesCommentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getLesEvenements(): Collection
    {
        return $this->lesEvenements;
    }

    public function addLesEvenement(Evenement $lesEvenement): static
    {
        if (!$this->lesEvenements->contains($lesEvenement)) {
            $this->lesEvenements->add($lesEvenement);
            $lesEvenement->setLeUtilisateur($this);
        }

        return $this;
    }

    public function removeLesEvenement(Evenement $lesEvenement): static
    {
        if ($this->lesEvenements->removeElement($lesEvenement)) {
            // set the owning side to null (unless already changed)
            if ($lesEvenement->getLeUtilisateur() === $this) {
                $lesEvenement->setLeUtilisateur(null);
            }
        }

        return $this;
    }
}
