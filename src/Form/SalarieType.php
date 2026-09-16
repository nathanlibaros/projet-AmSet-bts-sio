<?php

namespace App\Form;

use App\Entity\Competence;
use App\Entity\Salarie;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civilite', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => ['Monsieur' => 'Monsieur', 'Madame' => 'Madame'],
                'expanded' => true,
            ])
            ->add('nom', null, ['label' => 'Nom'])
            ->add('prenom', null, ['label' => 'Prénom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('telephone', TelType::class, ['label' => 'Téléphone', 'required' => false])
            ->add('adresse', null, ['label' => 'Adresse'])
            ->add('codePostal', null, ['label' => 'Code postal'])
            ->add('ville', null, ['label' => 'Ville'])
            ->add('site', EntityType::class, [
                'label' => 'Site',
                'class' => Site::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un site',
            ])
            ->add('competences', EntityType::class, [
                'label' => 'Compétences',
                'class' => Competence::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salarie::class,
        ]);
    }
}
