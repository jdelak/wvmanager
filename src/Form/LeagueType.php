<?php

namespace App\Form;

use App\Entity\League;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeagueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level', TextType::class, array(
                'label' => 'Level',
            ))
            ->add('pts_to_up', TextType::class, array(
                'label' => 'Pts to Up',
            ))
            ->add('pts_to_down', TextType::class, array(
                'label' => 'Pts to Down',
            ))
            ->add('id_parent', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Id Parent',
                'class' => League::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.id', 'ASC');
                },
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => League::class,
        ]);
    }
}
