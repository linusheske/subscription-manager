<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{

    #[Route('/api/test')]
    public function testApiCall(): JsonResponse
    {
        return new JsonResponse('test');
    }

}