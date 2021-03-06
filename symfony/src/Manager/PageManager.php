<?php

namespace App\Manager;

use App\Entity\Page;
use App\Repository\PageRepository;

final class PageManager
{
    public function __construct(private PageRepository $pageRepository)
    {
    }

    public function getMainParent(Page $parent = null): Page|null
    {
        if (!$parent) {
            return null;
        }

        $mainParent = $parent->getMainParent();
        if ($mainParent) {
            return $mainParent;
        }

        return $parent;
    }

    public function simpleSearch(?string $term): array {
        return $this->pageRepository->searchByTermQuery($term)->execute();
    }

    /**
     * Retourne les 5 dernières pages créées
     *
     * @return array
     */
    public function getLastCreatedPages(int $limit = 5): array {
        return $this->pageRepository->findBy([], ['createdAt' => 'DESC'], $limit);
    }
}
