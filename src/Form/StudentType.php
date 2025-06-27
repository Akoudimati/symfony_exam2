<?php

namespace App\Form;

use App\Entity\SchoolGroup;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, ['label' => 'Voornaam'])
            ->add('lastName', null, ['label' => 'Achternaam'])
            ->add('email', null, ['label' => 'Email'])
            ->add('age', null, ['label' => 'Leeftijd'])
            ->add('schoolGroup', EntityType::class, [
                'label' => 'Klas',
                'class' => SchoolGroup::class,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Opslaan', 'attr' => ['class' => 'btn btn-secondary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
