<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImagemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('src', FileType::class, array(
                'label' => 'Imagem da passagem',
                'data_class' => null
            ))
            ->add('passagem',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\Passagem',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u');
                    },
                    'choice_label' => 'titulo',
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Imagem'
        ));
    }
}
