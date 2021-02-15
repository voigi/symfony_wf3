<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Auteurs;
use App\Services\FakeArticleService;
use App\Entity\Commentaires;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticlesController extends AbstractController
{
	private $entityManager;

	private $fakeArticleService;

	private $articleRepository;

	public function __construct(EntityManagerInterface $entityManager, ArticlesRepository $articleRepository, FakeArticleService $fakeArticleService)
	{
		$this->entityManager = $entityManager;
		$this->articlesRepository = $articleRepository;
		$this->fakeArticleService = $fakeArticleService;
	}

	/**
	 * @Route ("article/create", name = "create_article")
	 * @isGranted("ROLE_AUTEUR")
	 */
	public function create(Request $request)
	{
		$user = $this->getUser();
		$article = new Articles;

		$article->setUser($user);
		$form = $this->createForm(ArticleType::class, $article);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($article);
			$this->entityManager->flush();

			//return $this->redirectToRoute('article_categories', ['id' => $article->getId()]);
			return new Response('Article enregistré');
		}

		return $this->render('articles/create.html.twig', ['form' => $form->createView()]);
	}

	/**
	 * @Route("/article", name="article_list")
	 */
	public function articleList(Request $request)
	{
		$articleList = $this->ArticlesRepository->findAll();

		return $this->render('articles/list.html.twig', ['articleList' => $articleList]);
	}

	/**
	 * @Route ("article/{id}", name = "article_categories",requirements={"id"="\d+"})
	 */
	public function getDetails(Request $request, int $id)
	{
		$article = $this->ArticlesRepository->find($id);

		$commentaire = new Commentaires;
		$commentaire->setArticles($article);
		$form = $this->createForm(CommentaireType::class, $commentaire);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($commentaire);
			$this->entityManager->flush();
		}

		return $this->render('articles\detail.html.twig', ['article' => $article, 'form' => $form->createView()]);
	}

	/**
	 * @Route ("article/fake", name = "article_fake")
	 * @IsGranted("ROLE_AUTEUR")
	 *
	 */
	public function createFakeArticle(Request $request)
	{
		$article = $this->fakeArticleService->getFakeArticle();
		$user = $this->getUser();
		$article->setUser($user);

		$form = $this->createForm(ArticleType::class, $article);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($article);
			$this->entityManager->flush();
		}

		return $this->render('articles\create.html.twig', ['form' => $form->createView()]);
	}

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