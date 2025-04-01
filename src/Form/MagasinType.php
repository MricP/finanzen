<?php
namespace App\Form;

use App\Entity\Article;
use App\Entity\Magasin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagasinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr' => ['class' => 'form-control magasin-name-input'],
            ])
            ->add('articles', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'nom', 
                'multiple' => true,
                'attr' => ['class' => 'form-control article-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Magasin::class,
        ]);
    }
}
