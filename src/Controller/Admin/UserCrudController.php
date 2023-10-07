<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $rolesChoices = [
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
        ];
        return [
            EmailField::new('email'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            TextField::new('password')->setFormType(PasswordType::class),
            TextField::new('address'),
            TextField::new('zipcode')->setMaxLength(5),
            TextField::new('city'),
            FormField::addPanel('Roles')->setIcon('fa fa-user')->setFormType(\Symfony\Component\Form\Extension\Core\Type\ChoiceType::class)
                ->setFormTypeOptions([
                    'choices' => [
                        'ROLE_USER' => 'ROLE_USER',
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                    ],
                    'multiple' => true,
                    // If you want to allow multiple roles
                    'expanded' => true,
                    // If you want the roles to be displayed as checkboxes
                ]),
            // ArrayField::new('roles')->setChoices($rolesChoices)->allowMultipleChoices(),
        ];
    }

}