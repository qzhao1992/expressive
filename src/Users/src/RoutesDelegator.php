<?php

namespace Announcements;

use Announcements\Handler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        $app = $callback();

        //Setup routes;
        $app->post('/announcements[/]', Handler\AnnouncementsCreateHandler::class, 'announcements.create');

        // $app->get('/announcements/{id:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}[/]', Handler\AnnouncementsViewHandler::class,'announcements.view');

        $app->get('/announcements/{id:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}[/]', Handler\AnnouncementsReadHandler::class, 'announcements.read');

        $app->put('/announcements/{id:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}[/]', Handler\AnnouncementsUpdateHandler::class, 'announcements.update');

        $app->delete('/announcements/{id:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}[/]', Handler\AnnouncementsDeleteHandler::class, 'announcements.delete');

        $app->get('/announcements/[?page={page:\d+}]', Handler\AnnouncementsListHandler::class, 'announcements.list');

        return $app;
    }

}