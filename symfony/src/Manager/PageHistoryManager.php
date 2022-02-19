<?php

namespace App\Manager;

use App\Entity\Page;
use App\Entity\PageHistory;
use App\Entity\User;
use App\Repository\PageHistoryRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\Security;

final class PageHistoryManager
{
    public function __construct(private Security $security, private PageHistoryRepository $pageHistoryRepository)
    {
    }

    /**
     * Créer un object PageHistory avec les informations de la page passées en paramètres
     *
     * @param Page $oldCopy Page avec les données à injecter dans la PageHistory
     * @param Page|null $page Page de référence
     * @return PageHistory
     */
    public function create(Page $oldCopy, Page|null $page): PageHistory
    {
        $pageHistory = new PageHistory();
        $pageHistory->setVersion($oldCopy->getVersion());
        $pageHistory->setName($oldCopy->getName());
        $pageHistory->setBody($oldCopy->getBody());
        $pageHistory->setDescription($oldCopy->getDescription());
        /** @var User $user */
        $user = $this->security->getUser();
        $pageHistory->setUpdatedBy($user);
        $pageHistory->setPage($page ?: $oldCopy);

        return $pageHistory;
    }

    /**
     * Retourne true si le nom, contenu ou la description d'une page est différent(e) de son ancienne version
     *
     * @param Page $newPage
     * @param Page $oldPage
     * @return bool
     */
    public function shouldCreateHistory(Page $newPage, Page $oldPage): bool
    {
        if (
            $newPage->getBody() !== $oldPage->getBody()
            || $newPage->getName() !== $oldPage->getName()
            || $newPage->getDescription() !== $oldPage->getDescription()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Retourne une version d'une page passée en paramètre.
     * Sinon null.
     *
     * @param Page $page
     * @param int $version
     * @return PageHistory|null
     */
    public function getPageHistoryByVersionNumber(Page $page, int $version): PageHistory|null
    {
        return $this->pageHistoryRepository->findOneBy(['page' => $page, 'version' => $version]);
    }
}
