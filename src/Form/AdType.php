<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null,
                array(
                    'attr' => array(
                        'placeholder' => 'Mon titre',
                    )),
                ["label" => "Titre"]
            )
            ->add('description')
            ->add('city', null, [
                "label" => "Ville",
                "attr" => [
                    "class" => "cityclass"
                ]
            ])
            ->add('zip', null, [
                "label" => "Code Postal"
            ])
            ->add('price', null, [
                "label" => "Prix demandé"
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Envoyer"
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
