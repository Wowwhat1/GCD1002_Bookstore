<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="app_book_index", methods={"GET"})
     */
    public function index(Request $request, BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
    {
        $search = $request->query->get('search');
        $query = $bookRepository->findMore($search);
        $book = $query->getResult();
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $category = $request->query->get('category');
        $book = $bookRepository->filter($minPrice, $maxPrice, $category);
        return $this->render('book/index.html.twig', [
            'books' => $book,
            'categories' => $categoryRepository->findAll(),
            'catNumber' => $category,
        ]);
    }

//    /**
//     * @Route("/filter", name="app_book_filter", methods={"GET"})
//     */
//    public function filter(Request $request, BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
//    {
//        $search = $request->query->get('search');
//        $query = $bookRepository->findMore($search);
//        $book = $query->getResult();
//        $minPrice = $request->query->get('minPrice');
//        $maxPrice = $request->query->get('maxPrice');
//        $book = $this->filter($minPrice, $maxPrice);
//        return $this->render('book/index.html.twig', [
//            'books' => $book,
//            'categories' => $categoryRepository->findAll(),
//        ]);
//    }

    /**
     * @Route("/addCart/{id}", name="app_add_cart", methods={"GET"})
     */
    public function addCart(Book $book, Request $request, BookRepository $bookRepository, LoggerInterface $logger): Response
    {
        $session = $request->getSession();
        $quantity = 1;

        //check if cart is empty
        if (!$session->has('cartElements')) {
            //if it is empty, create an array of pairs (prod Id & quantity) to store first cart element.
            $cartElements = array($book->getId() => $quantity);
            //save the array to the session for the first time.
            $session->set('cartElements', $cartElements);
        } else {
            $cartElements = $session->get('cartElements');
            //Add new product after the first time. (would UPDATE new quantity for added product)
            $cartElements = array($book->getId() => $quantity) + $cartElements;
            //Re-save cart Elements back to session again (after update/append new product to shopping cart)
            $session->set('cartElements', $cartElements);
        }
        $session->set('cartElements', $cartElements);

        return $this->renderForm('cart/addSuccessful.html.twig');
    }

    /**
     * @Route("/reviewCart", name="app_review_cart", methods={"GET"})
     */
    public function reviewCart(Request $request, BookRepository $bookRepository): Response
    {
        $session = $request->getSession();
        $idBook= (int)$request->query->get('idBook');
        $quantity = (int)$request->query->get('quantity');
        $temQuery = $bookRepository->findInfoBook($idBook);
        $session = $request->getSession();

        if ($session->has('cartElements')) {
            $cartElements = $session->get('cartElements');
        } else
            $cartElements = [];

        return $this->render('cart/cart.html.twig', [
            'bookInfos'=>$temQuery->getResult(),
            'quantity'=>$cartElements,
        ]);
    }

    /**
     * @Route("/updateCart", name="app_update_cart", methods={"GET"})
     */
    public function updateCart(Request $request): Response {
        $session = $request->getSession();
        $bookId = $request->get('idBook');
        $updatedQuantity = $request->get('quantity');
        $cartElements = $session->get('cartElements');

        foreach ($cartElements as $id => $quantity) {
            if ($bookId == $id)
                $quantity = $updatedQuantity;
        }
        return $this->redirectToRoute('app_review_cart',[
            $cartElements
        ],Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/deleteCart", name="app_delete_cart", methods={"GET"})
     */
    public function deleteCart(BookRepository $bookRepository, Request $request): Response
    {
        $session = $request->getSession();
        $idBook= $request->query->get('id');
        $quantity = (int)$request->query->get('quantity');

        //check if cart is empty
        if (!$session->has('cartElements')) {
            $cartElements = $session->get('cartElements');
        } else {
            $cartElements = $session->get('cartElements');
            unset($cartElements[$idBook]);
            $cartElements = $session->set('cartElements', $cartElements);
        }
        return $this->redirectToRoute('app_review_cart',[],Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/checkoutCart", name="app_checkout_cart", methods={"GET"})
     */
    public function checkoutCart(Request $request, OrderDetailRepository $orderDetailRepository, OrderRepository $orderRepository, BookRepository $bookRepository, ManagerRegistry $mr): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $mr->getManager();
        $session = $request->getSession(); //get a session
        // check if session has elements in cart
        if ($session->has('cartElements') && !empty($session->get('cartElements'))) {
            try {
                // start transaction!
                $entityManager->getConnection()->beginTransaction();
                $cartElements = $session->get('cartElements');

                //Create new Order and fill info for it. (Skip Total temporarily for now)
                $order = new Order();
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $order->setDate(new \DateTime());
                $user = $this->getUser();
                $order->setUser($user);
                $orderRepository->add($order, true); //flush here first to have ID in Order in DB.

                //Create all Order Details for the above Order
                $total = 0;
                foreach ($cartElements as $id => $quantity) {
                    $book = $bookRepository->find($id);
                    //create each Order Detail
                    $orderDetail = new OrderDetail();
                    $orderDetail->setOrderId($order);
                    $orderDetail->setBook($book);
                    $orderDetail->setQuantity($quantity);
                    $orderDetailRepository->add($orderDetail);

                    $total += $book->getCost() * $quantity;
                }
                $order->setSubTotal($total);
                $orderRepository->add($order);
                // flush all new changes (all order details and update order's total) to DB
                $entityManager->flush();

                // Commit all changes if all changes are OK
                $entityManager->getConnection()->commit();

                // Clean up/Empty the cart data (in session) after all.
                $session->remove('cartElements');
            } catch (Exception $e) {
                // If any change above got trouble, we roll back (undo) all changes made above!
                $entityManager->getConnection()->rollBack();
            }
            return new Response("Check in DB to see if the checkout process is successful");
        } else
            return new Response("Nothing in cart to checkout!");
    }

    // /**
    //  * @Route("/new", name="app_book_new", methods={"GET", "POST"})
    //  */
    // public function new(Request $request, BookRepository $bookRepository): Response
    // {
    //     $book = new Book();
    //     $form = $this->createForm(BookType::class, $book);
    //     $form->handleRequest($request);
    //     $search = $request->query->get('search');

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $bookImage = $form->get('Image')->getData();
    //         if ($bookImage) {
    //             $originExt = pathinfo($bookImage->getClientOriginalName(), PATHINFO_EXTENSION);
    //             $bookRepository->add($book, true);
    //             $newFilename = $book->getId() . '.' . $originExt;

    //             try {
    //                 $bookImage->move(
    //                     $this->getParameter('book_directory'),
    //                     $newFilename
    //                 );
    //             } catch (FileException $e) {
    //             }
    //             $book->setImgUrl($newFilename);
    //             $bookRepository->add($book, true);
    //         }
    //         return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('book/new.html.twig', [
    //         'book' => $book,
    //         'form' => $form,
    //         'search' => $search,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="app_book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="app_book_edit", methods={"GET", "POST"})
    //  */
    // public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    // {
    //     $form = $this->createForm(BookType::class, $book);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $bookRepository->add($book, true);

    //         return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('book/edit.html.twig', [
    //         'book' => $book,
    //         'form' => $form,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="app_book_delete", methods={"POST"})
    //  */
    // public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
    //         $bookRepository->remove($book, true);
    //     }

    //     return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    // }
}
