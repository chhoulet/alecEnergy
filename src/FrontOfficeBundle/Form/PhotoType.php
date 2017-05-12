<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PhotoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('filename', FileType::class, array('label'=>'Choisissez une photo (.png, .jpg, .jpeg'))
                ->add('submit', SubmitType::class, array('label'=>'Ajouter cette photo à l\'article',
                                                         'attr'=>['class'=>'btn btn-primary']))
                ->add('saveAndAdd', SubmitType::class, array('label'=>'Ajouter et joindre une autre photo',
                                                         'attr'=>['class'=>'btn btn-info']));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Photo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontofficebundle_photo';
    }


}
