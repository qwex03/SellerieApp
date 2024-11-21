<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Reparations;
use App\Entity\Statuts;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReparationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_signalement', null, [
                'widget' => 'single_text',
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'id',
            ])
            ->add('status', EntityType::class, [
                'class' => Statuts::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reparations::class,
        ]);
    }
}
