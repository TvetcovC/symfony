<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => ['style' => 'width: 100%; height: 30px']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['style' => 'width: 100%; height: 100px']
            ])
            ->add('credits', IntegerType::class, [
                'label' => 'Credits',
                'attr' => ['style' => 'width: 100%; height: 30px']
            ])
            ->add('category', EntityType::class, [
                'label' => 'Category',
                'class' => Category::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'attr' => ['style' => 'width: 100%; height: 30px']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Course',
                'attr' => ['style' => 'width: 100%; height: 30px']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
