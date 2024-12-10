<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Historique;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_retour', null, [
                'widget' => 'single_text',
            ])
            ->add('nom', null, [
                'attr' => [
                    'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
                    'placeholder' => 'Nom de la personne',
                ],
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->join('p.id_etat', 'e')
                        ->where('e.nom NOT IN (:excluded_states)')
                        ->setParameter('excluded_states', ['à réparer', "hors d'usage"]);
                },
                'attr' => [
                    'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
                    'placeholder' => 'Nom du produit',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Historique::class,
        ]);
    }
}
