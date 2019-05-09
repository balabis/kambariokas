<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                    'Prefer not to say' => 'default',
                ],
            ])
            ->add('dateOfBirth', BirthdayType::class, [
                'widget' => 'single_text',
            ])
            ->add('city', ChoiceType::class, [
                'choices' => array('Vilnius','Kaunas','Klaipėda','Šiauliai','Panevėžys','Alytus','Marijampolė',
                    'Mažeikiai','Jonava',
                    'Utena','Kėdainiai','Telšiai','Visaginas','Tauragė','Ukmergė','Plungė','Šilutė','Kretinga',
                    'Radviliškis','Druskininkai','Palanga','Rokiškis','Biržai','Gargždai','Kuršėnai','Elektrėnai',
                    'Jurbarkas','Garliava','Vilkaviškis','Raseiniai','Naujoji Akmenė','Anykščiai','Lentvaris',
                    'Grigiškės','Prienai','Joniškis','Kelmė','Varėna','Kaišiadorys','Pasvalys','Kupiškis','Zarasai',
                    'Skuodas','Kazlų Rūda','Širvintos','Molėtai','Švenčionėliai','Šakiai','Šalčininkai','Ignalina',
                    'Kybartai','Pabradė','Šilalė','Pakruojis','Nemenčinė','Trakai','Švenčionys','Vievis','Lazdijai',
                    'Kalvarija','Rietavas','Žiežmariai','Eišiškės','Ariogala','Venta','Šeduva','Birštonas','Akmenė',
                    'Tytuvėnai','Rūdiškės','Pagėgiai','Neringa','Vilkija','Žagarė','Viekšniai','Skaudvilė','Ežerėlis',
                    'Gelgaudiškis','Kudirkos Naumiestis','Simnas','Salantai','Linkuva','Veisiejai','Ramygala',
                    'Priekulė','Joniškėlis','Jieznas','Daugai','Obeliai','Varniai','Virbalis','Vabalninkas','Seda',
                    'Subačius','Baltoji Vokė','Dūkštas','Pandėlys','Dusetos','Užventis','Kavarskas','Smalininkai',
                    'Troškūnai','Panemunė'),
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
            ])
            ->add('aboutme', TextareaType::class, [
                'label' => 'About me',
                'required' => false,
            ])
            ->add('profilePicture', FileType::class, [
                'label' => 'Profile picture',
                'data_class' => null,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
