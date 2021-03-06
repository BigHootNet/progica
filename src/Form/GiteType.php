<?php

namespace App\Form;

use App\Entity\Gite;
use App\Entity\User;
use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('surface')
            ->add('chambre')
            ->add('couchage')
            ->add('equipements', EntityType::class, [
                "class" => Equipement::class,
                "choice_label" => "name",
                "multiple" => true,
            ])
            ->add('user', EntityType::class, [
                "class" => User::class,
                "choice_label" => "username",
                "multiple" => false,
                'choice_value' => ChoiceList::value($this, 'id')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gite::class,
        ]);
    }
}
