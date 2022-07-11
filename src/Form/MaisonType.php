<?php

namespace App\Form;

use App\Entity\Maison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomimmob')
            ->add('nom_loy')
            ->add('cin_loy')
            ->add('numero_tel')
            ->add('prix')
            ->add('deb')
            ->add('fin');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maison::class,
        ]);
    }
}
