<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitySelectionFormType extends AbstractType
{

    const VLINIUS = 0;
    const KAUNAS = 1;
    const KLAIPEDA = 2;
    const SIAULIAI = 3;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ChoseYourCity', ChoiceType::class, [
                'choices' => [
                    'Vilnius' => self::VLINIUS,
                    'Kaunas' => self::KAUNAS,
                    'Klaipeda' => self::KLAIPEDA,
                    'Siauliai' => self::SIAULIAI,
                ],
            ])
            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}