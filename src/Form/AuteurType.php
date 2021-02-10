<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuteurType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('nom', TextType::class, ['label' => 'Veuillez entrez un nom']);
		$builder->add('prenom', TextType::class, ['label' => 'Veuillez entrez un prenom', 'required' => false]);
		$builder->add('Sauvegarder', SubmitType::class, ['label' => 'Sauvegarder']);
	}
}