<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            Textfield::new('name', 'Nom'),
            Textfield::new('colorText', 'Couleur de texte'),
            TextareaField::new('colorBackground', 'Couleur de texte'),
            Textfield::new('icon', 'Icon'),
            Textfield::new('chapo', 'Chapeau'),
        ];
    }
}
