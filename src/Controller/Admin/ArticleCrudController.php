<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\AttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            CollectionField::new('attachments', 'Images')
                ->setEntryType(AttachmentType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
            CollectionField::new('attachments')
                ->setTemplatePath('images.html.twig')
                ->onlyOnDetail(),
            TextField::new('title', 'Titre'),
            TextField::new('chapo', 'Description')->hideOnIndex(),
            TextareaField::new('content', 'Contenu')->setFormType(CKEditorType::class)->hideOnIndex(),
            BooleanField::new('isPublish', 'Public'),
            AssociationField::new('category', 'Catégorie'),
            DateTimeField::new('createdAt', 'Date Création')->hideOnForm()->setFormat('short'),
            DateTimeField::new('updatedAt', 'Date Modification')->hideOnForm()->setFormat('short'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $sendInvoice = Action::new('me-3', 'Article', 'far fa-newspaper')
            ->linkToRoute('article_show', function (Article $article): array {
                return [
                    'slug' => $article->getSlug(),
                ];
            })->setCssClass("btn btn-primary");

        return $actions->add(CRUD::PAGE_INDEX, 'detail')
            ->add(CRUD::PAGE_EDIT, $sendInvoice);
    }
}
