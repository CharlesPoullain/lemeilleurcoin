<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                        'placeholder' => 'Titre de l\'annonce',
                    )),
                ["label" => "Titre"]
            )
            ->add('description', null, [
                "label" => "Description",
                "attr" => [
                    'placeholder' => 'Description de l\'annonce',
                ]
            ])
            ->add('city', null, [
                "label" => "Ville",
                "attr" => [
                    'placeholder' => 'Ville',
                    "class" => "cityclass"
                ]
            ])
            ->add('zip', null, array(
                'attr' => array(
                    'placeholder' => 'Code postal',
                )),[
                "label" => "Code Postal"
            ])
            ->add('price', null,array(
                'attr' => array(
                    'placeholder' => 'Prix de l\'annonce',
                )), [
                "label" => "Prix demandé"
            ])
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'DESC');
                },
            ))
            ->add('pictures', CollectionType::class,
                array(
                    'label' => 'Image',
                    'entry_type' => PictureType::class
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
