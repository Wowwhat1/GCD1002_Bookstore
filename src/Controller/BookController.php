<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
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
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        $search = $request->query->get('search');
        $query = $bookRepository->findMore($search);
        $book = $query->getResult();
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == 'ROLE_ADMIN') {
            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('book/index.html.twig', [
            'books' => $book,
        ]);
    }

    /**
     * @Route("/addCart/{id}", name="app_add_cart", methods={"GET"})
     */
    public function addCart(Book $book, Request $request): Response
    {
        $session = $request->getSession();
        $quantity = (int)$request->query->get('quantity');

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
        return new Response(); //means 200, successful
    }

    /**
     * @Route("/reviewCart", name="app_review_cart", methods={"GET"})
     */
    public function reviewCart(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->has('cartElements')) {
            $cartElements = $session->get('cartElements');
        } else
            $cartElements = [];
        return $this->json($cartElements);
    }

    /**
     * @Route("/deleteCart", name="app_delete_cart", methods={"GET"})
     */
    public function deleteCart(Book $book, Request $request): Response
    {
        $session = $request->getSession();
        $quantity = (int)$request->query->get('quantity');

        //check if cart is empty
        if (!$session->has('cartElements')) {
            $cartElements = $session->get('cartElements');
        } else {
            $cartElements = $session->get('cartElements');
            //Add new product after the first time. (would UPDATE new quantity for added product)
            $cartElements = array($book->getId() => $quantity) + $cartElements;
            //Re-save cart Elements back to session again (after update/append new product to shopping cart)
            $session->set('cartElements', $cartElements);
        }
        return new Response();
    }


    /**
     * @Route("/new", name="app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        $search = $request->query->get('search');

        if ($form->isSubmitted() && $form->isValid()) {
            $bookImage = $form->get('Image')->getData();
            if ($bookImage) {
                $originExt = pathinfo($bookImage->getClientOriginalName(), PATHINFO_EXTENSION);
                $bookRepository->add($book, true);
                $newFilename = $book->getId() . '.' . $originExt;

                try {
                    $bookImage->move(
                        $this->getParameter('book_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $book->setImgUrl($newFilename);
                $bookRepository->add($book, true);
            }
            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
