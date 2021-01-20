<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('urlFile', VichFileType::class, [
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/png',
                        ]
                    ]),
                ],
                'allow_delete' => true,
                'download_uri' => true,
                'label' => 'Selectionner une photo'])
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Chats' => 'Chats',
                    'Chiens' => 'Chiens',
                    'Oiseaux' => 'Oiseaux',
                    'Miroirs' => 'Miroirs',
                    'Bibliotheques' => 'Bibliotheques',
                    'Sur-mesure' => 'Sur-mesure'
                ]
            ])
            ->add('texte_alternatif', TextType::class)
            ->add('otherImages', HiddenType::class, [
                'mapped' => false,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
