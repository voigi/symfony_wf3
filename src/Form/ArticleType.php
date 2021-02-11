<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('titre', TextType::class, ['label' => 'Veuillez entrez un titre']);
		$builder->add('soustitre', TextType::class, ['label' => 'Veuillez entrez un soustitre']);
		$builder->add('contenu', TextareaType::class, ['label' => 'Veuillez entrez un contenu']);
		$builder->add('choix', ChoiceType::class, ['choices' => 'Veuillez entrez un contenu']);
		$builder->add('Sauvegarder', SubmitType::class, ['label' => 'Sauvegarder']);
	}
}