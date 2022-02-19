<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Tag;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la page',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ma super page'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Courte description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quelle est l\'utilité de cette page ? ...'
                ]
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'label' => 'Tag',
                'placeholder' => 'Aucun label',
                'required' => false
            ])
            ->add('parameters', PageParameterType::class, [
                'label' => 'Paramètres de la page'
            ])
            ->add('body', CKEditorType::class, [
                'label' => 'Contenu de la page',
                'required' => false,
                'config' => [
                    'editorplaceholder' => 'Le contenu de la page peut rester vide.'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
