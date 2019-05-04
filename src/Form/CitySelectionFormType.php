<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CitySelectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ChoseYourCity', ChoiceType::class, [
                'choices' => [
                    'Vilnius' => 'Vilnius',
                    'Kaunas' => 'Kaunas',
                    'Klaipėda' => 'Klaipėda',
                    'Šiauliai' => 'Šiauliai',
                    'Panevėžys' => 'Panevėžys',
                    'Alytus' => 'Alytus',
                    'Marijampolė' => 'Marijampolė',
                    'Mažeikiai' => 'Mažeikiai',
                    'Jonava' => 'Jonava',
                    'Utena' => 'Utena',
                    'Kėdainiai' => 'Kėdainiai',
                    'Tauragė' => 'Tauragė',
                    'Telšiai' => 'Telšiai'
                ],
            ])
            ->add('Save', SubmitType::class);
    }
}
