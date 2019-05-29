<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Component\Validator\Constraints\Range;

class MatchFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('gender', Filters\ChoiceFilterType::class, [
              'choices' => [
                  'Does not matter' => 'default',
                  'Male' => 'male',
                  'Female' => 'female',
                  ],
              ])
            ->add('MatchPercent', Filters\NumberFilterType::class, [
                'constraints' => [
                    new Range([
                        'min'=> 50,
                        'max' => 100,
                        'minMessage' => "Value must be between 50 and 100",
                        'maxMessage' => "Value must be between 50 and 100",
                        ]),
                ],
            ])
            ->add('budget', Filters\ChoiceFilterType::class, [
                'choices' => array('iki 50eur/mėn', 'iki 100eur/mėn', 'iki 200eur/mėn', '> 200eur/mėn'),
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
                'required' => false
            ])
            ->add('age', Filters\NumberRangeFilterType::class);
    }
}
