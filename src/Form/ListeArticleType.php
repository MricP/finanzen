<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Liste;
use App\Entity\ListeArticle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListeArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('est_achete')
            ->add('quantite')
//            ->add('articles', EntityType::class, [
//                'class' => Article::class,
//                'choice_label' => 'id',
//            ])
//            ->add('listes', EntityType::class, [
//                'class' => Liste::class,
//                'choice_label' => 'id',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListeArticle::class,
        ]);
    }
}
