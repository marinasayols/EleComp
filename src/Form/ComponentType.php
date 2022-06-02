<?php

namespace App\Form;

use App\Entity\Component;
use App\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value')
            ->add('tolerance')
            ->add('price')
            ->add('manufacturers', EntityType::class, [
                'expanded' => true,
                'multiple' => true,
                'class' => Manufacturer::class,
                'choice_label' => 'name',
            ])
            ->add('provider', CollectionType::class, [

            ])
            /*->add('providers', ProviderFormType::class)->add('providers', EntityType::class, [
                'expanded' => true,
                'multiple' => true,
                'class' => Provider::class,
                'choice_label' => 'name',
            ])*/
        ;

        /*$builder->addEventListener(FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                if (!empty($data['providersNew']['name'])) {
                    $form->add('providersNew', ProviderType::class, [
                        'mapped' => true,
                        'property_path' => 'providers'
                    ]);
                }
            });*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Component::class,
        ]);
    }
}
