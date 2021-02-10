<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Auteurs;
use App\Form\AuteurType;
use App\Repository\AuteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;

class AuteursController extends AbstractController
{
	private $entityManager;

	private $auteurManager;

	public function __construct(EntityManagerInterface $entityManager, AuteursRepository $auteurRepository)
	{
		$this->entityManager = $entityManager;
		$this->auteurRepository = $auteurRepository;
	}

	/**
	 * @Route ("auteur/create", name = "create_auteurs")
	 */
	public function create(Request $request)
	{
		$auteur = new Auteurs;
		$formBuilder = $this->createFormBuilder($auteur);
		$formBuilder->add('nom', TextType::class, ['label' => 'Veuillez entrez un nom']);
		$formBuilder->add('prenom', TextType::class, ['label' => 'Veuillez entrez un prenom', 'required' => false]);
		$formBuilder->add('Sauvegarder', SubmitType::class, ['label' => 'Sauvegarder']);
		$form = $formBuilder->getForm();

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($auteur);
			$this->entityManager->flush();

			return $this->redirectToRoute('detail_auteur', ['id' => $auteur->getId()]);
		}

		return $this->render('auteurs/create.html.twig', ['form' => $form->createView()]);
	}

	/**
	 * @Route ("auteur/{id}", name = "detail_auteur")
	 */
	public function getDetails(Request $request, int $id)
	{
		$auteur = $this->auteurRepository->find($id);

		return $this->render('auteurs\detail.html.twig', ['auteur' => $auteur]);
	}

	/**
	*@Route("/auteur/{id}/update", name="update_auteur")
	*/
	public function update(Request $request, int $id)
	{
		$auteur = $this->auteurRepository->find($id);

		$form = $this->createForm(AuteurType::class, $auteur);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($auteur);
			$this->entityManager->flush();

			return $this->redirectToRoute('detail_auteur', ['id' => $auteur->getId()]);
		}

		return $this->render('auteurs/update.html.twig', ['formulaire' => $form->CreateView()]);
	}

	/**
	*@Route("/auteur", name="list_auteur")
	*/
	public function list(Request $request)
	{
		$auteurList = $this->auteurRepository->findAll();

		return $this->render('auteurs/list.html.twig', ['auteurList' => $auteurList]);
	}
}