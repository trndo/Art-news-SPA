<?php


namespace App\Form;


use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,[
                'label' => "Ім'я"
            ])
            ->add('translationName',TextType::class,[
                'label' => "Ім'я на англ."
            ])
            ->add('phone',TextType::class,[
                'label' => 'Номер телефону'
            ])
            ->add('email',EmailType::class,[
                'label' => 'Електронна пошта'
            ])
            ->add('save',SubmitType::class, [
                'label' => 'Зберегти'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Settings::class
        ]);
    }

}