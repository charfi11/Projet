<?php

namespace App\Form;

use App\Entity\Trophee;
use App\Entity\Eventuser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UsereventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lieu')
            ->add('date')
            ->add('url')
            ->add('trophee', EntityType::class, [
                'class' => Trophee::class,
                'label'  => 'Résultat',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eventuser::class,
        ]);
    }
}
