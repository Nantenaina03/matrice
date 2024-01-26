<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Mois', ChoiceType::class, [
                'choices' => [
                    'Janvier' => '1',
                    'Février' => '2',
                    'Mars' => '3',
                    'Avril' => '4',
                    'Mai' => '5',
                    'Juin' => '6',
                    'Juillet' => '7',
                    'Août' => '8',
                    'Septembre' => '9',
                    'Octobre' => '10',
                    'Novembre' => '11',
                    'Décembre' => '12',
                ],// Si vous voulez afficher les options en tant que radios ou cases à cocher
            ])
            ->add('Annees', ChoiceType::class, [
                'choices' => [
                    '2018' => '18',
                    '2019' => '19',
                    '2020' => '20',
                    '2021' => '21',
                    '2022' => '22',
                    '2023' => '23',
                    '2024' => '24',
                    '2025' => '25',
                    '2026' => '26',
                    '2027' => '27',
                    '2028' => '28',
                    '2029' => '29',
                    '2030' => '30',
                ],
            ])
            ->add('Maternite', IntegerType::class, [
                'label'=>'Maternité'
            ])
            ->add('Medecine', IntegerType::class, [])
            ->add('Actes_Chirurgicaux', IntegerType::class, [])
            ->add('Pediatrie', IntegerType::class, [
                'label'=>'Pédiatrie'
            ])
            ->add('Ophtalmo', IntegerType::class, [])
            ->add('ATU', IntegerType::class, [
                'label'=>'ATU'
            ])
            ->add('Banque_de_sang', IntegerType::class, [])
            ->add('Tiers_service', IntegerType::class, [])
            ->add('CE_CM', IntegerType::class, [
                'label'=>'CE CM'
            ])
            ->add('ECG', IntegerType::class, [
                'label'=>'ECG'
            ])
            ->add('Echo', IntegerType::class, [])
            ->add('Radio', IntegerType::class, [])
            ->add('Labo', IntegerType::class, [])
            ->add('Stomato', IntegerType::class, [])
            ->add('Hebergement_salle_payante', IntegerType::class, [])
            ->add('Hebergement_salle_commune', IntegerType::class, [])
            ->add('Marge_beneficiaire', IntegerType::class, [
                'label'=>'Marge bénéficiaire des médicaments'
            ])
            ->add('DONS', IntegerType::class, [
                'label'=>'DONS'
            ])
            ->add('Envoyer', SubmitType::class, [
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}