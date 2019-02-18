<?php

namespace AppBundle\Form;

use AppBundle\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickEditType extends AbstractType
{
    public function getParent()
    {
        return TrickType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_edit';
    }

}
