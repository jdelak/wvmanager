<?php

namespace App\Form;

use App\Entity\Ethnicity;
use App\Entity\Faction;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EthnicityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, array(
            'label' => 'Name',
        ))
        ->add('id_faction', EntityType::class, [
            // looks for choices from this entity
            'label' => 'Faction',
            'class' => Faction::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('f')
                    ->orderBy('f.name', 'ASC');
            },
            'choice_label' => 'name',
        ])
        ->add('imageFile', VichImageType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ethnicity::class,
        ]);
    }
}
