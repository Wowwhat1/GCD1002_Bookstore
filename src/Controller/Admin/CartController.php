<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use App\Form\OrderDetailType;
use App\Repository\BookRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderDetailRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class CartController extends AbstractController {
//    /**
//     * @Route("/addCart/{id}", name="app_add_cart", methods={"GET"})
//     */
//    public function addCart(Book $book, Request $request, BookRepository $bookRepository, LoggerInterface $logger): Response
//    {
//        $session = $request->getSession();
//        $quantity = (int)$request->query->get('quantity');
//        $cat = $request->query->get('category');
//        $idBook = (int)$request->query->get('idBook');
//        $temQuery = $bookRepository->findAll();
//        $page = (int)$request->query->get('pageWeb');
//        $pageSize = 4;
//        $totalItems = count($temQuery);
//        $logger->info("id: ".$idBook);
//        $numOfPages = ceil($totalItems/$pageSize);
//        $logger->info($numOfPages);
//        $logger->info("a".$page);
//
//        //check if cart is empty
//        if (!$session->has('cartElements')) {
//            //if it is empty, create an array of pairs (prod Id & quantity) to store first cart element.
//            $cartElements = array($book->getId() => $quantity);
//            //save the array to the session for the first time.
//            $session->set('cartElements', $cartElements);
//        } else {
//            $cartElements = $session->get('cartElements');
//            //Add new product after the first time. (would UPDATE new quantity for added product)
//            $cartElements = array($book->getId() => $quantity) + $cartElements;
//            //Re-save cart Elements back to session again (after update/append new product to shopping cart)
//            $session->set('cartElements', $cartElements);
//        }
//        $session->set('cartElements', $cartElements);
//        $c = count($cartElements);
//        $session->set('count', $c);
//
//
//        return $this->renderForm('cart/addSuccessful.html.twig', [
//            'count'=>$c
//        ]);
//    }
//
//    /**
//     * @Route("/updateCart", name="app_update_cart", methods={"GET"})
//     */
//    public function updateCart(Request $request) {
//
//    }
//
//
//    /**
//     * @Route("/reviewCart", name="app_review_cart", methods={"GET"})
//     * @param Request $request
//     * @param $bookRepository
//     * @return Response
//     */
//    public function reviewCart(Request $request, BookRepository $bookRepository): Response
//    {
//        $session = $request->getSession();
//        $product = $bookRepository;
//        $quantity = 1;
//        if ($session->has('cartElements')) {
//            $cartElements = $session->get('cartElements');
//        } else
//            $cartElements = [];
//        return $this->renderForm('cart.html.twig');
//    }
//
//    /**
//     * @Route("/deleteCart", name="app_delete_cart", methods={"GET"})
//     */
//    public function deleteCart(Book $book, Request $request): Response
//    {
//        $session = $request->getSession();
//        $quantity = (int)$request->query->get('quantity');
//
//        //check if cart is empty
//        if (!$session->has('cartElements')) {
//            $cartElements = $session->get('cartElements');
//        } else {
//            $cartElements = $session->get('cartElements');
//            //Add new product after the first time. (would UPDATE new quantity for added product)
//            $cartElements = array($book->getId() => $quantity) + $cartElements;
//            //Re-save cart Elements back to session again (after update/append new product to shopping cart)
//            $session->set('cartElements', $cartElements);
//        }
//        return new Response();
//    }
//
//    /**
//     * @Route("/checkoutCart", name="app_checkout_cart", methods={"GET"})
//     */
//    public function checkoutCart(Request $request, OrderDetailRepository $orderDetailRepository, OrderRepository $orderRepository, BookRepository $bookRepository, ManagerRegistry $mr): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_USER');
//        $entityManager = $mr->getManager();
//        $session = $request->getSession(); //get a session
//        // check if session has elements in cart
//        if ($session->has('cartElements') && !empty($session->get('cartElements'))) {
//            try {
//                // start transaction!
//                $entityManager->getConnection()->beginTransaction();
//                $cartElements = $session->get('cartElements');
//
//                //Create new Order and fill info for it. (Skip Total temporarily for now)
//                $order = new Order();
//                date_default_timezone_set('Asia/Ho_Chi_Minh');
//                $order->setDate(new \DateTime());
//                $user = $this->getUser();
//                $order->setUser($user);
//                $orderRepository->add($order, true); //flush here first to have ID in Order in DB.
//
//                //Create all Order Details for the above Order
//                $total = 0;
//                foreach ($cartElements as $product_id => $quantity) {
//                    $product = $bookRepository->find($product_id);
//                    //create each Order Detail
//                    $orderDetail = new OrderDetail();
//                    $orderDetail->setOrderId($order);
//                    $orderDetail->setBook($product);
//                    $orderDetail->setQuantity($quantity);
//                    $orderDetailRepository->add($orderDetail);
//
//                    $total += $product->getCost() * $quantity;
//                }
//                $order->setSubTotal($total);
//                $orderRepository->add($order);
//                // flush all new changes (all order details and update order's total) to DB
//                $entityManager->flush();
//
//                // Commit all changes if all changes are OK
//                $entityManager->getConnection()->commit();
//
//                // Clean up/Empty the cart data (in session) after all.
//                $session->remove('cartElements');
//            } catch (Exception $e) {
//                // If any change above got trouble, we roll back (undo) all changes made above!
//                $entityManager->getConnection()->rollBack();
//            }
//            return new Response("Check in DB to see if the checkout process is successful");
//        } else
//            return new Response("Nothing in cart to checkout!");
//    }
}