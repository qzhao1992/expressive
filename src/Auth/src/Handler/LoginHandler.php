<?php

declare(strict_types=1);

namespace Auth\Handler;

use Auth\Entity\Account;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class LoginHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $pageCount;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        // $this->pageCount = $pageCount;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // $requestBody = $request->getParsedBody();

        // if(empty($requestBody)){
        //     $result['_error']['error'] = 'missing_request';
        //     $result['_error']['error_description'] = 'No request body sent.';

            
            
        //     return new JsonResponse($result, 400);
        // }

        // $entityRepository = $this->entityManager->getRepository(Account::class);
        // $entity = $entityRepository->find($requestBody['username']);

        

        // if(empty($entity)){
        //     $result['_error']['error'] = 'Unauthorized';
        //     $result['_error']['error_description'] = 'Unauthorized';
            
        //     return new JsonResponse($result, 401);
        // }


        

        $query = $this->entityManager->getRepository('Auth\Entity\Account')
        ->createQueryBuilder('c')
        ->getQuery();

        $paginator = new Paginator($query);

        $records = $paginator
        ->getQuery()
        ->getResult(Query::HYDRATE_ARRAY);
        

        return new JsonResponse($records);
    }
}
