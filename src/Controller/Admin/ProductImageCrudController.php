<?php

namespace App\Controller\Admin;

use App\Entity\ProductImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProductImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductImage::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('url')
                ->setBasePath('uploads/images/') // Define the base path for displaying images
                ->setUploadDir('public/uploads/images/') // Define the directory for uploading images
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Define the file name pattern
                ->setRequired(false),
            AssociationField::new('product'),
        ];
    }

}