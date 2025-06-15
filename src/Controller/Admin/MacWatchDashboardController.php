<?php

namespace App\Controller\Admin;

use App\Entity\ActivityEntity;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class MacWatchDashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public function index(): Response
    {
        return $this->redirect($this->adminUrlGenerator->setController(ActivityEntityCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MacWatchServer');
    }

    public function configureMenuItems(): iterable
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
        }

        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Computer Activity');
            yield MenuItem::linkToCrud('Activity', 'fa fa-tags', ActivityEntity::class)
                ->setController(ActivityEntityCrudController::class);
        }

        yield MenuItem::section('Computer Activity Tic');
        yield MenuItem::linkToCrud('Activity Tic', 'fa fa-tags', ActivityEntity::class)
            ->setController(ActivityEntityTicTicCrudController::class);

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Computer Activity Jmd');
            yield MenuItem::linkToCrud('Activity Jmd', 'fa fa-tags', ActivityEntity::class)
                ->setController(ActivityEntityJmdCrudController::class);
        }
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
