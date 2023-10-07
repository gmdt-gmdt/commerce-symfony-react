<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            NumberField::new('price'),
            PercentField::new('discountPercentage'),
            IntegerField::new('rating'),
            IntegerField::new('stock'),
            TextField::new('brand'),
            ImageField::new('thumbnail')
                ->setBasePath('uploads/images/') // Define the base path for displaying images
                ->setUploadDir('public/uploads/images/') // Define the directory for uploading images
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Define the file name pattern
                ->setRequired(false),
            // Make it required or not as per your needs,
            AssociationField::new('category'),
            AssociationField::new('image'),

        ];
    }

}