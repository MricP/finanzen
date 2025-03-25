<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Magasin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', null, [
                'attr' => ['class' => 'form-control price-input'],
            ])
            ->add('nom', null, [
                'attr' => ['class' => 'form-control name-input'],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'form-control category-select'],
            ])
            ->add('magasins', EntityType::class, [
                'class' => Magasin::class,
                'choice_label' => 'id',
                'multiple' => true,
                'attr' => ['class' => 'form-control store-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
