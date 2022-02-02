<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qteSortie', TextType::class, array('label'=>'Quantité vendue','attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('dateSortie', DateType::class, array('label'=>'Date de vente', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('produit', EntityType::class, array('class'=>Produit::class,'label'=>'Libelle du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
