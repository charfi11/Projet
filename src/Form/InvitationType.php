<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Invite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label'  => 'Ajouter des membres',
                'choice_label' => 'username',
                'multiple' => true,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invite::class,
        ]);
    }
}
