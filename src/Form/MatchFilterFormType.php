<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

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
            ->add('MatchPercent', Filters\NumberFilterType::class)
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
