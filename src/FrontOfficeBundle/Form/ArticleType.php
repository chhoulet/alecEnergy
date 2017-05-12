<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array('label'=>'Titre',
                                                      'attr'=>['class'=>'form-control']))
                ->add('subject', TextType::class, array('label'=>'Sujet',
                                                        'required'=>false,
                                                        'attr'=>['class'=>'form-control']))
                ->add('main', TextareaType::class, array('label'=>'Texte',
                                                         'attr'=>['class'=>'tinymce']))
                ->add('dateCreated', DateType::class, array('label'=>'Date de parution',
                                                            'required'=>false,
                                                            'widget' => 'single_text',
                                                            'format' => 'dd-MM-yyyy',
                                                            'html5'=>false,                                                           
                                                            'attr' => ['class' => 'js-datepicker']))
                ->add('dateDeleted', DateType::class, array('label'=>'Date d\'expiration',
                                                            'required'=>false,
                                                            'widget' => 'single_text',
                                                            'format' => 'dd-MM-yyyy',
                                                            'html5'=>false,                                                           
                                                            'attr' => ['class' => 'js-datepicker']))
                ->add('submit', SubmitType::class, array('label'=>'Enregistrer',
                                                         'attr' =>array('class'=>'btn btn-success')))
                ->add('saveAndAdd', SubmitType::class, array('label' => 'Enregistrer et ajouter une image',
                                                             'attr' =>array('class'=>'btn btn-success')));
    }
    
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontofficebundle_article';
    }


}
