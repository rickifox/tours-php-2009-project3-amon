<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            /*->add('url', TextType::class, [
                'label' => 'url',
                'required' => true,
            ])*/
            ->add('urlFile', VichImageType::class, [
                'label' => 'Image',
                'required' => true,
                'allow_delete' => false,
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Aménagement Extérieur' => 'outdoor layout',
                    'Brise-vue et Pare-soleil' => 'privacy screen and sun visor',
                    'Décoration' => 'decoration',
                    'Escaliers' => 'stairs',
                    'Garde-corps' => 'railing',
                    'Passages secrets' => 'secret passage',
                    'Trappes vitrées' => 'glass trap',
                    'Verrières' => 'canopy',
                    'Autre' => 'other',
                ],
                'label' => 'Catégorie',
                'required' => true,
            ])
            ->add('alternativeText', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
            ])
            /*->add('updatedAt')*/
            /*->add('article')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
