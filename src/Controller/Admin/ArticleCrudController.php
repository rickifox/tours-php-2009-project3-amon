<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('title', 'Titre'),
            DateField::new('date', 'Le'),
            TextEditorField::new('content', 'Contenu'),
            BooleanField::new('isNews', 'Actualité'),
            CollectionField::new('images', 'Image')
                ->onlyOnForms()
                ->allowAdd()
                ->allowDelete()
                ->setEntryType(ImageCrudController::class),
            ];
    }
}
