<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Historique;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RetourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('retour', CheckboxType::class, [
                'label' => 'Retour',
            ])
            
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'mapped' => false,  
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')->orderBy('e.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'block w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Historique::class,
        ]);
    }
}
