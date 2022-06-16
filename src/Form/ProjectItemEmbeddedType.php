<?php

namespace App\Form;

use App\Entity\Component;
use App\Entity\ProjectItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectItemEmbeddedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('component', EntityType::class, [
                'class' => Component::class,
                'choice_label' => 'name'
            ])
            ->add('qty', NumberType::class);
        $builder->addEventListener(FormEvents::POST_SET_DATA, [$this, 'onPostSetData']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectItem::class,
        ]);
    }

    public function onPostSetData(FormEvent $event)
    {
        if ($event->getData() && $event->getData()->getId()) {
            $form = $event->getForm();
            unset($form['component']);
        }
    }
}
