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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarieType extends AbstractType
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $langue = $this->requestStack->getCurrentRequest()?->getLocale() ?? 'fr';

        $builder
            ->add('civilite', ChoiceType::class, [
                'label' => 'champ.civilite',
                // La valeur enregistrée reste en français (contrainte de la base),
                // seul le libellé affiché est traduit.
                'choices' => ['civilite.monsieur' => 'Monsieur', 'civilite.madame' => 'Madame'],
                'expanded' => true,
            ])
            ->add('nom', null, ['label' => 'champ.nom'])
            ->add('prenom', null, ['label' => 'champ.prenom'])
            ->add('email', EmailType::class, ['label' => 'champ.email'])
            ->add('telephone', TelType::class, ['label' => 'champ.telephone', 'required' => false])
            ->add('adresse', null, ['label' => 'champ.adresse'])
            ->add('codePostal', null, ['label' => 'champ.code_postal'])
            ->add('ville', null, ['label' => 'champ.ville'])
            ->add('site', EntityType::class, [
                'label' => 'champ.site',
                'class' => Site::class,
                'choice_label' => 'nom',
                'choice_translation_domain' => false,
                'placeholder' => 'champ.choisir_site',
            ])
            ->add('competences', EntityType::class, [
                'label' => 'champ.competences',
                'class' => Competence::class,
                // Libellé affiché dans la langue courante du site
                'choice_label' => fn (Competence $competence) => $competence->getLibelleTraduit($langue),
                'choice_translation_domain' => false,
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
