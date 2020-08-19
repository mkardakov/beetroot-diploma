<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    public function index(ProductRepository $productRepository)
    {
        return $this->render('home/index.html.twig', [
            'offers' => $productRepository->findBy(['isSale' => 1], ['addedAt' => 'desc'], 4)
        ]);
    }
}
