<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // TODO : problem with illustration and price !
        // https://symfony.com/bundles/EasyAdminBundle/current/fields.html#field-layout

        return [
            TextField::new('name'),
            TextField::new('illustration'),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            MoneyField::new('price'),
            AssociationField::new('category'),
        ];
    }
}
