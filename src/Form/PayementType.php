<?php

namespace App\Form;

use App\Entity\Payement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('mois')
            ->add('paye', ChoiceType::class, array(
                'choices'  => array(
                    'non payé' => 'non payé',
                    'payé' => 'payé',

                ),
                'expanded' => true
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payement::class,
        ]);
    }
}
