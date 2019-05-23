<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class MatchFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('gender', ChoiceType::class, [
              'choices' => [
                  'Does not matter' => 'default',
                  'Male' => 'male',
                  'Female' => 'female',
                  ],
              ])
            ->add('minAge', NumberType::class, [
                'attr' => [
                    'min' => 10,
                    'max'=>80,
                    ],
                'required' => false
            ])
            ->add('maxAge', NumberType::class, [
                'attr' => [
                    'min' => 10,
                    'max'=>80,
                ],
                'required' =>false

            ])
            ->add('minCost', NumberType::class, [
                'attr' => [
                    'min' => 10,
                    'max'=>80,
                ],
                'required' => false
            ])
            ->add('maxCost', NumberType::class, [
                'attr' => [
                    'min' => 10,
                    'max'=>80,
                ],
                'required' =>false

            ])
            ->add("MatchPercent", NumberType::class, [
                'attr' => [
                    'min' => 50,
                    'max'=>100,
                ],
                'required' =>false
            ]);
    }
}
