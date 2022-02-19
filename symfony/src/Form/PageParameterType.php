<?php

namespace App\Form;

use App\Entity\PageParameter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('showHierarchy', CheckboxType::class, [
                'label' => 'Afficher l\'arborescence',
                'required' => false,
            ])
            ->add('openHierarchyByDefault', CheckboxType::class, [
                'label' => 'Par défaut, ouvrir l\'onglet d\'arborescence si il est affiché',
                'required' => false,
            ])
            ->add('showVersions', CheckboxType::class, [
                'label' => 'Afficher les anciennes versions',
                'required' => false,
            ])
            ->add('openVersionsByDefault', CheckboxType::class, [
                'label' => 'Par défaut, ouvrir l\'onglet des versions si il est affiché',
                'required' => false,
            ])
            ->add('openTodolistByDefault', CheckboxType::class, [
                'label' => 'Par défaut, ouvrir l\'onglet de la liste des tâches',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PageParameter::class,
        ]);
    }
}
