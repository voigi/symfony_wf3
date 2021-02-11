<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ArticlesController extends AbstractController
{
	private $entityManager;

	private $articleRepository;

	public function __construct(EntityManagerInterface $entityManager, ArticlesRepository $articleRepository)
	{
		$this->entityManager = $entityManager;
		$this->categoryRepository = $articleRepository;
	}

	/**
	 * @Route ("category/create", name = "create_category")
	 */
	public function create(Request $request)
	{
		$article = new Articles;
		$form = $this->createForm(ArticleType::class, $article);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($article);
			$this->entityManager->flush();

			return $this->redirectToRoute('article_categories', ['id' => $article->getId()]);
		}

		return $this->render('articles/create.html.twig', ['form' => $form->createView()]);
	}

	/**
	 * @Route ("category/{id}", name = "detail_categories")
	 */
	public function getDetails(Request $request, int $id)
	{
		$article = $this->categoryRepository->find($id);

		return $this->render('articles\detail.html.twig', ['article' => $article]);
	}

	// 	/**
// 	 * @Route ("category/{id}/delete", name = "delete_categories")
// 	 */
// 	public function delete(Request $request, int $id)
// 	{
// 		$category = $this->categoryRepository->find($id);
// 		$this->entityManager->remove($category);
// 		$this->entityManager->flush();

// 		return $this->redirectToRoute('list_categories');
// 	}

// 	/**
// 	*@Route("/category/{id}/update", name="update_categories")
// 	*/
// 	public function update(Request $request, int $id)
// 	{
// 		$category = $this->categoryRepository->find($id);

// 		$form = $this->createForm(CategoryType::class, $category);

// 		$form->handleRequest($request);
// 		if ($form->isSubmitted() && $form->isValid()) {
// 			$this->entityManager->persist($category);
// 			$this->entityManager->flush();

// 			return $this->redirectToRoute('detail_categories', ['id' => $category->getId()]);
// 		}

// 		return $this->render('categories/update.html.twig', ['formulaire' => $form->CreateView()]);
// 	}

// 	/**
// 	*@Route("/category", name="list_categories")
// 	*/
// 	public function list(Request $request)
// 	{
// 		$categoriesList = $this->categoryRepository->findAll();

// 		return $this->render('categories/list.html.twig', ['categoriesList' => $categoriesList]);
// 	}
}