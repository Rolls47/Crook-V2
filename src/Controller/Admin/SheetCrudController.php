<?php

namespace App\Controller\Admin;

use App\Entity\Sheet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class SheetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sheet::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextField::new('description', 'Description'),
            TextareaField::new('content', 'Contenu')->setFormType(CKEditorType::class)->setFormTypeOptions([
                'label' => 'Contenu :',
                'config' => [
                    'toolbar' => 'standard',
                    'extraPlugins' => 'codesnippet',
                    'codeSnippet_theme' => 'monokai',
                ],
                'plugins' => [
                    'codesnippet' => [
                        'path' => '/build/ckeditor/extra-plugins/codesnippet/',
                        'filename' => 'plugin.js',
                    ],
                ],
            ]),
            AssociationField::new('author', 'auteur'),
            AssociationField::new('language', 'langage'),
            DateField::new('createAt', 'Crée le')->hideOnForm(),
            DateField::new('updateAt', 'Maj')->hideOnForm(),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->setSearchFields(['id', 'title', 'description', 'content', 'author.pseudo', 'language.name', 'createAt', 'updateAt']);
    }
}
