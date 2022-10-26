<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Publisher;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bookstore');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('The Label', 'fas fa-list', Book::class);
        yield MenuItem::linkToCrud('The Label', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('The Label', 'fas fa-list', Order::class);
        yield MenuItem::linkToCrud('The Label', 'fas fa-list', OrderDetail::class);
        yield MenuItem::linkToCrud('The Label', 'fas fa-list', Publisher::class);
        yield MenuItem::linkToCrud('The Label', 'fas fa-list', User::class);
    }
}
