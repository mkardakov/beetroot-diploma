<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Rating;
use App\Service\Cart\Cart;
use App\Service\Cart\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{

    /**
     * @param Product $product
     * @return Response
     */
    public function index(Product $product)
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function addVote(Product $product, Request $request, EntityManagerInterface $em)
    {
        $voteVal = $request->request->get('vote');
        $token = $request->request->get('token');
        if (!$this->isCsrfTokenValid('add_to_cart', $token)) {
            throw new BadRequestException('Wrong CSRF token. Are you robot?');
        }
        $vote = new Rating();
        $vote->setValue($voteVal);
        $product->addRating($vote);
        $em->persist($vote);
        $em->persist($product);
        $em->flush();
        return new Response($product->getCurrentRating());
    }

    public function addToCart(Product $product, SessionInterface $session)
    {
        $session->start();
        $products = $session->has('order') ? $session->get('order') : [];
        if (empty($products[$product->getId()])) {
            $products[$product->getId()] = 0;
        }

        $products[$product->getId()]++;

        $session->set('order', $products);
        return new Response();
    }

    public function showCart(Cart $cart)
    {
        return $this->render('product/cart_modal.html.twig', [
            'cart' => $cart
        ]);
    }

    public function removeFromCart(Product $product, Cart $cart)
    {
        $cart->removeItemByProduct($product);
        return new Response($cart->getTotal());
    }

    public function updateItemCount(Product $product, Cart $cart, Request $request)
    {
        $count = $request->request->get('count');
        $item = new Item($product, $count);
        $cart->updateItem($item);
        $result = [
            'item-price' => $item->getCost(),
            'total' => $cart->getTotal()
        ];
        return new Response(json_encode($result));
    }
}
