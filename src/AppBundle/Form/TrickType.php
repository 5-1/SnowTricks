<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('slug')
            ->add('content')
            ->add('images', CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false,
                    'by_reference' => false
                ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'by_reference' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
//                'multiple' => false,
//                'expanded' => true
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Trick::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_trick';
    }


}
