<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Emplacement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('nom', null, [
            'attr' => [
                'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
                'placeholder' => 'Nom du produit',
            ],
        ])
        ->add('id_categorie', EntityType::class, [
            'class' => Categorie::class,
            'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.nom_categorie', 'ASC');
            },
            'choice_label' => 'nom_categorie',
            'attr' => [
                'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
            ],
        ])
        ->add('id_emplacement', EntityType::class, [
            'class' => Emplacement::class,
            'choice_label' => function (Emplacement $emplacement) {
                return $emplacement->getRayon() . ' - ' . $emplacement->getEtagere();
            },
            'attr' => [
                'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
            ],
        ])
        ->add('id_etat', EntityType::class, [
            'class' => Etat::class,
            'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
            },
            'choice_label' => 'nom',
            'attr' => [
                'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
            ],
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
