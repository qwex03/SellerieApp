<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Reparations;
use App\Entity\Statuts;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Reparations1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_signalement', null, [
                'widget' => 'single_text',
            ])
            ->add('date_start', null, [
                'widget' => 'single_text',
            ])
            ->add('date_end', null, [
                'widget' => 'single_text',
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
            ])
            ->add('status', EntityType::class, [
                'class' => Statuts::class,
                'choice_label' => 'etat',
            ])
            ->add('reparateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
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
