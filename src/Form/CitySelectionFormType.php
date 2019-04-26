<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CitySelectionFormType extends AbstractType
{
    const VILNIUS = 2;
    const KAUNAS = 1;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ChoseYourCity', ChoiceType::class, [
                'choices' => [
                    'Vilnius' => self::VILNIUS,
                    'Kaunas' => self::KAUNAS,
                ],
            ])
            ->add('Save', SubmitType::class);
    }

}