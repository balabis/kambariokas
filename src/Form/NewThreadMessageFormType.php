<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Message form type for starting a new conversation.
 */
class NewThreadMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipient', UsernameFormType::class, array(
                'label' => 'recipient',
                'translation_domain' => 'FOSMessageBundle',
            ))
            ->add('subject', TextType::class, array(
                'label' => 'subject',
                'translation_domain' => 'FOSMessageBundle',
            ))
            ->add('body', TextareaType::class, array(
                'translation_domain' => 'FOSMessageBundle',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'intention' => 'message',
        ));
    }

    public function getBlockPrefix()
    {
        return 'new_thread_message';
    }
}