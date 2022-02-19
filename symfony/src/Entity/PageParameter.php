<?php

namespace App\Entity;

use App\Repository\PageParameterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageParameterRepository::class)]
class PageParameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'parameters', targetEntity: Page::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $page;

    #[ORM\Column(type: 'boolean')]
    private $showHierarchy;

    #[ORM\Column(type: 'boolean')]
    private $openHierarchyByDefault;

    #[ORM\Column(type: 'boolean')]
    private $showVersions;

    #[ORM\Column(type: 'boolean')]
    private $openVersionsByDefault;

    #[ORM\Column(type: 'boolean')]
    private $openTodolistByDefault;

    public function __construct() {
        $this->openHierarchyByDefault = true;
        $this->showHierarchy = true;
        $this->showVersions = true;
        $this->openVersionsByDefault = false;
        $this->openTodolistByDefault = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getShowHierarchy(): ?bool
    {
        return $this->showHierarchy;
    }

    public function setShowHierarchy(bool $showHierarchy): self
    {
        $this->showHierarchy = $showHierarchy;

        return $this;
    }

    public function getOpenHierarchyByDefault(): ?bool
    {
        return $this->openHierarchyByDefault;
    }

    public function setOpenHierarchyByDefault(bool $openHierarchyByDefault): self
    {
        $this->openHierarchyByDefault = $openHierarchyByDefault;

        return $this;
    }

    public function getShowVersions(): ?bool
    {
        return $this->showVersions;
    }

    public function setShowVersions(bool $showVersions): self
    {
        $this->showVersions = $showVersions;

        return $this;
    }

    public function getOpenVersionsByDefault(): ?bool
    {
        return $this->openVersionsByDefault;
    }

    public function setOpenVersionsByDefault(bool $openVersionsByDefault): self
    {
        $this->openVersionsByDefault = $openVersionsByDefault;

        return $this;
    }

    public function getOpenTodolistByDefault(): ?bool
    {
        return $this->openTodolistByDefault;
    }

    public function setOpenTodolistByDefault(bool $openTodolistByDefault): self
    {
        $this->openTodolistByDefault = $openTodolistByDefault;

        return $this;
    }
}
