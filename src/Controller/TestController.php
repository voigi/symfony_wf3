<?php

namespace App\Controller;

use App\Entity\Auteurs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @Route("/test", name = "test")
	 */
	public function test(Request $request)
	{
		return new Response('<h1>Hello World !</h1>');
	}

	/**
	 * @Route("/test/persist", name = "test_persist")
	 */
	public function testPersist(Request $request)
	{
		$auteur = new Auteurs();
		$auteur->setNom('Baste');
		$auteur->setPrenom('Bertrand');

		$this->entityManager->persist($auteur);
		$this->entityManager->flush();

		return new Response('enregistrement OK');
	}
}