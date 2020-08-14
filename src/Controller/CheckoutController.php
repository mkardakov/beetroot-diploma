<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Service\Cart\Cart;
use App\Service\Cart\Item;
use App\Service\OrderMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CheckoutController
 * @package App\Controller
 */
class CheckoutController extends AbstractController
{

    /**
     * @param Cart $cart
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param OrderMailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function index(Cart $cart, Request $request, EntityManagerInterface $em, OrderMailer $mailer)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($cart->isEmpty()) {
                throw new BadRequestException('You are not permitted to do this action');
            }
            $order->setStatus(0);
            if ($this->isGranted('ROLE_USER')) {
                $order->setUser($this->getUser());
            }
            /** @var Item $item */
            foreach ($cart->getItems() as $item) {
                $orderProduct = new OrderProduct();
                $orderProduct->setLinkedOrder($order);
                $orderProduct->setProduct($item->getProduct());
                $orderProduct->setCost($item->getCost());
                $orderProduct->setTotal($item->getCount());
                $em->persist($orderProduct);
            }
            $em->persist($order);
            $em->flush();
            $mailer->mail($order);
            $cart->clear();

            return $this->redirectToRoute('checkout', ['status' => '1']);
        }
        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }


    /**
     * @param OrderRepository $repository
     * @return Response
     */
    public function getOrdersHistory(OrderRepository $repository)
    {
        $orders = $repository->findBy(['user' => $this->getUser()]);
        return $this->render('checkout/history.html.twig', [
            'orders' => $orders
        ]);
    }
}
