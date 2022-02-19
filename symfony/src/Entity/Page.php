<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $body;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?Page $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $children;

    #[ORM\OneToOne(mappedBy: 'page', targetEntity: PageParameter::class, cascade: ['persist', 'remove'])]
    private PageParameter $parameters;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pages')]
    #[ORM\JoinColumn(nullable: true)]
    private User $author;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'allDescendantPages')]
    private ?Page $mainParent;

    #[ORM\OneToMany(mappedBy: 'mainParent', targetEntity: self::class)]
    private ?Collection $allDescendantPages;

    #[ORM\ManyToOne(targetEntity: Tag::class, inversedBy: 'pages')]
    private $tag;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: PageHistory::class, orphanRemoval: true)]
    private $pageHistories;

    #[ORM\Column(type: 'integer')]
    private ?int $version;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Todo::class, orphanRemoval: true)]
    private ?Collection $todos;

    #[Pure] public function __construct(User $author, PageParameter $parameters, Page $parent = null, Page $mainParent = null)
    {
        $this->mainParent = $mainParent;
        $this->parent = $parent;
        $this->setParameters($parameters); // Appeler le setter pour obtenir la logique nécessaire
        $this->author = $author;

        $this->children = new ArrayCollection();
        $this->createdAt = null;
        $this->updatedAt = null;

        $this->allDescendantPages = new ArrayCollection();
        $this->pageHistories = new ArrayCollection();
        $this->version = 1;
        $this->description = null;
        $this->todos = new ArrayCollection();
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getParameters(): ?PageParameter
    {
        return $this->parameters;
    }

    public function setParameters(PageParameter $parameters): self
    {
        // set the owning side of the relation if necessary
        if ($parameters->getPage() !== $this) {
            $parameters->setPage($this);
        }

        $this->parameters = $parameters;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime());
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getMainParent(): ?self
    {
        return $this->mainParent;
    }

    public function setMainParent(?self $mainParent): self
    {
        $this->mainParent = $mainParent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getAllDescendantPages(): Collection
    {
        return $this->allDescendantPages;
    }

    public function addAllDescendantPage(self $allDescendantPage): self
    {
        if (!$this->allDescendantPages->contains($allDescendantPage)) {
            $this->allDescendantPages[] = $allDescendantPage;
            $allDescendantPage->setMainParent($this);
        }

        return $this;
    }

    public function removeAllDescendantPage(self $allDescendantPage): self
    {
        if ($this->allDescendantPages->removeElement($allDescendantPage)) {
            // set the owning side to null (unless already changed)
            if ($allDescendantPage->getMainParent() === $this) {
                $allDescendantPage->setMainParent(null);
            }
        }

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPageHistories(): Collection
    {
        return $this->pageHistories;
    }

    /**
     * @return Collection
     */
    public function getSortedPageHistories(): Collection {
        $criteria = Criteria::create()
            ->orderBy(['version' => Criteria::DESC]);

        return $this->pageHistories->matching($criteria);
    }

    public function addPageHistory(PageHistory $pageHistory): self
    {
        if (!$this->pageHistories->contains($pageHistory)) {
            $this->pageHistories[] = $pageHistory;
            $pageHistory->setPage($this);
        }

        return $this;
    }

    public function removePageHistory(PageHistory $pageHistory): self
    {
        if ($this->pageHistories->removeElement($pageHistory)) {
            // set the owning side to null (unless already changed)
            if ($pageHistory->getPage() === $this) {
                $pageHistory->setPage(null);
            }
        }

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Incrémente de 1 la version
     *
     * @return void
     */
    public function updateVersion(): void {
        $this->setVersion($this->getVersion() + 1);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = trim($description);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTodos(): Collection
    {
        return $this->todos;
    }

    public function addTodo(Todo $todo): self
    {
        if (!$this->todos->contains($todo)) {
            $this->todos[] = $todo;
            $todo->setPage($this);
        }

        return $this;
    }

    public function removeTodo(Todo $todo): self
    {
        if ($this->todos->removeElement($todo)) {
            // set the owning side to null (unless already changed)
            if ($todo->getPage() === $this) {
                $todo->setPage(null);
            }
        }

        return $this;
    }
}

