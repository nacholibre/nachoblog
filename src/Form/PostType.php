<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
            ])
            ->add('draft', CheckboxType::class, [
                'label' => 'Draft (only visible for you)',
                'required' => false,
            ])
            ->add('readmore', TextType::class, [
                'label' => 'Readmore tag (put this in order to split your post with readmore button)',
                'mapped' => false,
                'disabled' => true,
                'data' => Post::READMORE_SPLIT_TAG,
            ])
            ->add('text', CKEditorType::class, [
                'label' => 'Content',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
