<?php

namespace App\Form;

use App\Entity\Component;
use App\Entity\Manufacturer;
use App\Entity\Provider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('value')
            ->add('tolerance')
            ->add('price', MoneyType::class)
            ->add('manufacturers', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('providers', EntityType::class, [
                'class' => Provider::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Component::class,
        ]);
    }
}
