<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('projectItems', CollectionType::class, [
                'entry_type' => ProjectItemEmbeddedType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $data['projectItems'] = array_values($data['projectItems']);
        $event->setData($data);
    }
}
