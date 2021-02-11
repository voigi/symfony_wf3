<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentaireType;
use App\Form\DeleteForm;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CommentairesController extends AbstractController
{
	public function __construct(EntityManagerInterface $entityManager, CommentairesRepository $commmentairesRepository)
	{
		$this->entityManager = $entityManager;
		$this->commentairesRepository = $commmentairesRepository;
	}

	/**
	 * @Route("/commentaires/{id}", name="commentaires_details",requirements={"id"="\d+"})
	 */
	public function getDetails(Request $request, int $id)
	{
		$commentaire = $this->commentairesRepository->find($id);
		if ($commentaire === null) {
			throw new  NotFoundHttpException('commentaire introuvable');
		}
		$deleteForm = $this->createForm(DeleteForm::class);
		$deleteForm->handleRequest($request);
		if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
			$this->entityManager->remove($commentaire);
			$this->entityManager->flush();

			return $this->redirectToRoute('commentaire_list');
		}

		return $this->render('commentaires/details.html.twig', ['commentaire' => $commentaire, 'deleteForm' => $deleteForm->createView()]);
	}

	/**
	 * @Route("/commentaire/", name="commentaire_list")
	 */
	public function getList(Request $request)
	{
		$commentaireList = $this->commentairesRepository->findAll();

		return $this->render('commentaires/list.html.twig', ['commentaireList' => $commentaireList]);
	}

	/**
	 * @Route("/commentaire/create", name="commentaire_create")
	 */
	public function create(Request $request)
	{
		$commentaire = new Commentaires();
		$form = $this->createForm(CommentaireType::class, $commentaire);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($commentaire);
			$this->entityManager->flush();

			return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);

			return new Response('commentaire enregistré');
		}

		return $this->render('commentaires/create.html.twig', ['formulaire' => $form->createView()]);
	}

	/**
	 * @Route("/commentaire/{id}/update", name="commentaire_update",requirements={"id"="\d+"})
	 */
	public function update(Request $request, int $id)
	{
		$commentaire = $this->commentairesRepository->find($id);
		if ($commentaire === null) {
			throw new  NotFoundHttpException('commentaire introuvable');
		}
		$form = $this->createForm(CommentaireType::class, $commentaire);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($commentaire);
			$this->entityManager->flush();

			return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
		}

		return $this->render('commentaires/update.html.twig', ['formulaire' => $form->createView()]);
	}

	// /**
	//  * @Route("/chien/{id}/delete", name="chien_delete",requirements={"id"="\d+"})
	//  */
	// public function delete(Request $request, int $id)
	// {
	// 	$chien = $this->chienRepository->find($id);
	// 	if ($chien === null) {
	// 		throw new  NotFoundHttpException('chien introuvable');
	// 	}

	// 	$this->entityManager->remove($chien);
	// 	$this->entityManager->flush();

	// 	return $this->redirectToRoute('chien_list');
	// }
}