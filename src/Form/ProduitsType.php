<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prix',)
            ->add('taille',)
            ->add('couleur',)
            ->add('description',)
            ->add('categories', EntityType::class,[
                'class'=>Categories::class,
                'choice_label'=>function($choix){
                    return $choix->getNom(). " ".$choix->getGenre();
                },
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image produit',
                'required' => true,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'image en format .jpg , .webp ou .png uniquement',
                    ])
                ],
            ])
            ->add('enregistrer', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
          'data_class'=>Produits::class,
        ]);
    }
}
