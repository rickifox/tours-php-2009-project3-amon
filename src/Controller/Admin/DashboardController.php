<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Image;
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
            ->setTitle('Administration Amon')
            ->setFaviconPath('build/images/favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Image', 'fas fa-edit', Image::class),
            MenuItem::linkToCrud('Article', 'fas fa-edit', Article::class),
            MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt'),
        ] ;
    }
}
