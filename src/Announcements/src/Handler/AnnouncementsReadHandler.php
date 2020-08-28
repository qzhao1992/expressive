<?php

declare(strict_types=1);

namespace Announcements\Handler;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AnnouncementsReadHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $pageCount;
    protected $urlHelper;

    public function __construct(EntityManager $entityManager, $pageCount)
    {
        $this->entityManager = $entityManager;
        $this->pageCount = $pageCount;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $query = $this->entityManager->getRepository('Announcements\Entity\Announcement')
        ->createQueryBuilder('c')
        ->getQuery();
        

        $paginator = new Paginator($query);

        $totalItems = count($paginator);
        $currentPage = ($request->getAttribute('page')) ? : 1;
        $totalPageCount = ceil($totalItems / $this->pageCount);
        $nextPage = (($currentPage < $totalPageCount) ? $currentPage + 1 : $totalPageCount);
        $previousPage = (($currentPage > 1) ? $currentPage - 1: 1);

        $records = $paginator
        ->getQuery()
        ->setFirstResult($this->pageCount * ($currentPage - 1))
        ->setMaxResults($this->pageCount)
        ->getResult(Query::HYDRATE_ARRAY);

        // $result['_embedded'] = [1 => 'test', 2 => 'test2'];
        
        $result['_embedded']['Announcements'] = $records;
        return new JsonResponse($result);
    }
}
