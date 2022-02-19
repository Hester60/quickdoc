<?php

namespace App\Entity;

use App\Enum\HexaColor;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $label;

    #[ORM\Column(type: 'color', length: 255)]
    private HexaColor $color;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: Page::class)]
    private $pages;

    public function __construct()
    {
        $this->color = HexaColor::GREEN;
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getColor(): ?HexaColor
    {
        return $this->color;
    }

    public function setColor(?HexaColor $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setTag($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getTag() === $this) {
                $page->setTag(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }
}
