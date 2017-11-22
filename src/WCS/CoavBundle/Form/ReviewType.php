<?php
/**
 * Created by PhpStorm.
 * User: wilder14
 * Date: 15/11/17
 * Time: 16:15
 */

namespace WCS\CoavBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    /**
     * {@inheritdoc} Including all fields from Review entity.
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, array('attr' => array('maxlength' => 250, 'label' => 'Description')))
            ->add('publicationDate', DateType::class, array('data' => new \DateTime('now')))
            ->add('note', IntegerType::class, array('attr' => array('min' => 0, 'max' => 5, 'label' => 'Note')))
            ->add('userRated', EntityType::class, array(
                'class' => 'WCS\CoavBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er ->createQueryBuilder('u')
                        ->orderBy('u.lastName','ASC');
                },
                'choice_label' => 'phoneNumber'
            ))
            ->add('reviewAuthor');
    }

    /**
     * {@inheritdoc} Targeting Review entity
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WCS\CoavBundle\Entity\Review'
        ));
    }

    /**
     * {@inheritdoc} getName() is now deprecated
     */

   public function getBlockPrefix()
   {
         return 'wcs_coavbundle_review';
   }
}