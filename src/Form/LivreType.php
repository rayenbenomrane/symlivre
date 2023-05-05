<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('resume')
            ->add('prix')
            ->add('image')
            ->add('editeur', ChoiceType::class, ['label' => 'editeur', 'choices' => ['eni' => 'eni', 'uno' => 'uno', 'ca' => 'ca']])
            ->add('dateEdition')
            ->add('categorie', EntityType::class, ['class' => Categories::class, 'choice_label' => 'libelle'])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
