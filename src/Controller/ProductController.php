<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    public function index(Product $product)
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

    public function addVote(Product $product, Request $request, EntityManagerInterface $em)
    {
        $voteVal = $request->request->get('vote');
        $vote = new Rating();
        $vote->setValue($voteVal);
        $product->addRating($vote);
        $em->persist($vote);
        $em->persist($product);
        $em->flush();
        return new Response();
    }
}
