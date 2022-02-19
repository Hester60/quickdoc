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
}
