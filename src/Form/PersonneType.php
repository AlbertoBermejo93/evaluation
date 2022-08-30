<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $submitButton = [
            'class' => 'btn btn-success',
        ];
    
        $builder
            ->add('nom', TextType::class,[
                'label'=> 'Nom',
                // 'placeholder'=> 'Indiquez votre nom famille',
            ])
            ->add('prenom', TextType::class,[
                'label'=> 'Prénom',
                // 'placeholder'=> 'Indiquez votre prénom',
            ])
            ->add('dateNaissance', BirthdayType::class,[
                'label'=> 'Date de naissance',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('valider',SubmitType::class,[
                'attr' => $submitButton,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
