<?php

namespace App\Form;

use App\Entity\Youtube;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class YoutubeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class)
            ->add('name', TextType::class)
            ->add('image', FileType::class, [          // Champs pour charger un fichier (image)                
                'mapped' => false,                          // Dissocier l'image de l'entité
                'required'=> false,                         // Rendre l'ajout d'image obligatoire
                'constraints' => [                          // Sécurité pour que le fichier soit une image au format jpg uniquement
                    new File([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Image au format jpg uniquement',
                    ])
                ],
            ])          
            ->add('Envoyer', SubmitType::class, [               // Ajouter directement le bouton submit ici
                'attr' =>['class' => 'btn btn-dark']
            ])                                     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Youtube::class,
        ]);
    }
}
