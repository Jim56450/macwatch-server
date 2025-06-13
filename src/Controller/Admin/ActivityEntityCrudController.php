<?php

namespace App\Controller\Admin;

use App\Entity\ActivityEntity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActivityEntityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ActivityEntity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('computerId'),
            TextField::new('appName'),
            TextField::new('windowTitle'),
            TextField::new('url'),
            DateTimeField::new('startTime'),
            DateTimeField::new('endTime'),
            //TextEditorField::new('description'),
        ];
    }
}
