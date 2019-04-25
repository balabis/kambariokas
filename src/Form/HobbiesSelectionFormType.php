<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HobbiesSelectionFormType extends AbstractType
{

    const BASKETBALL = 'basketball';
    const EATING = 'eating';
    const FILMS = 'films';
    const DOSOMETHING = 'something';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ChoseYourHobbies', ChoiceType::class, [
                'choices' => [
                    'basketball' => self::BASKETBALL,
                    'eating' => self::EATING,
                    'films' => self::FILMS,
                    'something' => self::DOSOMETHING,
                ],
                'expanded'  => true,
                'multiple'  => true,
            ])
            ->add('Save', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {

    }
}