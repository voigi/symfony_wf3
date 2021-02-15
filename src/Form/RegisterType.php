<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('nom', TextType::class, ['label' => 'Veuillez entrer un nom']);
		$builder->add('prenom', TextType::class, ['label' => 'Veuillez entrer votre prenom']);
		$builder->add('email', EmailType::class, ['label' => 'Veuillez entrer votre mail']);
		$builder->add('password', PasswordType::class, ['label' => 'Veuillez entrer votre mot de passe']);
		$builder->add('Valider', SubmitType::class, ['label' => 'S\'inscrire']);
	}
}