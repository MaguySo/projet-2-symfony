<?php

namespace App\Form;

use App\Entity\Fruit;
use App\Entity\Category;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FruitType extends AbstractType
{
    /**
     * Définir la configuration de base d'un champ - Factorisation
     * 
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $options =[])
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'category', EntityType::class,
                [
                    'class'=> Category::class,
                    'label'=> "Choisissez une catégorie",
                    'choice_label'=>'title'
                ]
            )
            ->add('name',
                TextType::class,
                $this->getConfiguration("Nom","Nom latin, nom commun, appelations…")
            )

            ->add('slug',
                TextType::class,
                $this->getConfiguration("Slug","Automatique",[
                    'required' => false
                ])
            )

            ->add('introduction',
                TextType::class,
                $this->getConfiguration("Introduction","Présentation sommaire, citation…")
            )

            ->add('content',
                TextareaType::class,
                $this->getConfiguration("Contenu","Description détaillée du fruit…")
            )

            ->add('price',
                MoneyType::class,
                $this->getConfiguration("Prix/kg","Indiquez le prix…")
            )

            ->add('coverImage',
                UrlType::class,
                $this->getConfiguration("URL de l'image principale","Misez sur une belle photo qui donne envie de dévorer des fruits à pleines dents !")
            )

            ->add('images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fruit::class,
            ]
        );
    }
}
