<?php

declare(strict_types=1);

namespace Auth\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class LoginHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LoginHandler
    {
        $entityManager  = $container->get(EntityManager::class);
        return new LoginHandler($entityManager);
    }
}
