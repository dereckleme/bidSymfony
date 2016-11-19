<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PassagemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('descricao')
            ->add(
                'agencia',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\Agencia',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u');
                    },
                    'choice_label' => 'nome',
                )
            )
            ->add('categoria',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\Categoria',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u');
                    },
                    'choice_label' => 'titulo',
                ))
            ->add('cidade',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\Cidade',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u');
                    },
                    'choice_label' => 'nome',
                ))
            ->add('estado',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\Estado',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u');
                    },
                    'choice_label' => 'nome',
                ))
            ->add('leilao',
                EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\Leilao',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u');
                    },
                    'choice_label' => 'id',
                ))
            ->add('imagem', FileType::class, array(
                'label' => 'Imagem da passagem'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Passagem'
        ));
    }
}
