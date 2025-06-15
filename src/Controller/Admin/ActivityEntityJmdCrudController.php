<?php

namespace App\Controller\Admin;

use App\Entity\ActivityEntity;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActivityEntityJmdCrudController extends AbstractCrudController
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $queryBuilder->andWhere('entity.computerId = :computerId')
            ->setParameter('computerId', 'MDR')
            ->orderBy('entity.id', 'DESC');


        return $queryBuilder;
    }
}
