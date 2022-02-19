<?php

namespace App\Manager;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;

class TodoManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function updateIsDone(Todo $todo): Todo
    {
        $todo->setIsDone(!$todo->getIsDone());

        return $todo;
    }
}
