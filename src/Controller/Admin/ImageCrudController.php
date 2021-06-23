<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            ChoiceField::new('category', 'Catégorie')
                ->setChoices([
                    'Aménagement Extérieur' => 'outdoor layout',
                    'Brise-vue et Pare-soleil' => 'privacy screen and sun visor',
                    'Décoration' => 'decoration',
                    'Escaliers' => 'stairs',
                    'Garde-corps' => 'railing',
                    'Passages secrets' => 'secret passage',
                    'Trappes vitrées' => 'glass trap',
                    'Verrières' => 'canopy',
                    'Autre' => 'other',
                ])
                ->allowMultipleChoices(false)
                ->renderExpanded(true),
            TextField::new('alternativeText', 'Texte alternatif'),
            ImageField::new('url', 'Image')
                ->onlyOnIndex()
                ->setBasePath($this->getParameter('upload_directory')),
            Field::new('urlFile', 'Image')
                ->onlyOnForms()
                ->setFormType(VichImageType::class),
            AssociationField::new('article'),
        ];
    }
}
