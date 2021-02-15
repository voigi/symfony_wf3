<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\DeleteForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
	public function __construct(EntityManagerInterface $entityManager, UserRepository $usersRepository, UserPasswordEncoderInterface $encoder)
	{
		$this->entityManager = $entityManager;
		$this->userRepository = $usersRepository;
		$this->userPasswordEncoderInterface = $encoder;
	}

	// /**
	//  * @Route("/commentaires/{id}", name="commentaires_details",requirements={"id"="\d+"})
	//  */
	// public function getDetails(Request $request, int $id)
	// {
	// 	$commentaire = $this->commentairesRepository->find($id);
	// 	if ($commentaire === null) {
	// 		throw new  NotFoundHttpException('commentaire introuvable');
	// 	}
	// 	$deleteForm = $this->createForm(DeleteForm::class);
	// 	$deleteForm->handleRequest($request);
	// 	if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
	// 		$this->entityManager->remove($commentaire);
	// 		$this->entityManager->flush();

	// 		return $this->redirectToRoute('commentaire_list');
	// 	}

	// 	return $this->render('commentaires/details.html.twig', ['commentaire' => $commentaire, 'deleteForm' => $deleteForm->createView()]);
	// }

	// /**
	//  * @Route("/commentaire/", name="commentaire_list")
	//  */
	// public function getList(Request $request)
	// {
	// 	$commentaireList = $this->commentairesRepository->findAll();

	// 	return $this->render('commentaires/list.html.twig', ['commentaireList' => $commentaireList]);
	// }

	/**
	 * @Route("/utilisateur/create", name="utilisateur_create")
	 */
	public function create(Request $request)
	{
		$user = new User();
		$form = $this->createForm(RegisterType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//bien penser à encoder le mot de passe avec le UserPasswordEncoder !!!!
			$encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
			$user->setPassword($encodedPassword); //set du password encodé
			$user->setRoles(['ROLE_USER']); //définition des roles de l'utilisateur
			$this->entityManager->persist($user);
			$this->entityManager->flush();

			return $this->redirectToRoute('app_login');

			// return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
		}

		return $this->render('utilisateurs/create.html.twig', ['formulaire' => $form->createView()]);
	}

	// /**
	//  * @Route("/commentaire/{id}/update", name="commentaire_update",requirements={"id"="\d+"})
	//  */
	// public function update(Request $request, int $id)
	// {
	// 	$commentaire = $this->commentairesRepository->find($id);
	// 	if ($commentaire === null) {
	// 		throw new  NotFoundHttpException('commentaire introuvable');
	// 	}
	// 	$form = $this->createForm(CommentaireType::class, $commentaire);
	// 	$form->handleRequest($request);

	// 	if ($form->isSubmitted() && $form->isValid()) {
	// 		$this->entityManager->persist($commentaire);
	// 		$this->entityManager->flush();

	// 		return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
	// 	}

	// 	return $this->render('commentaires/update.html.twig', ['formulaire' => $form->createView()]);
	// }

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