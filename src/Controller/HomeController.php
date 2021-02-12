<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	/**
	 * @var ArticlesRepository
	 */
	private $repository;

	public function __construct(ArticlesRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @Route("/", name="home")
	 */
	public function home(Request $request)
	{
		$articleList = $this->repository->ListDesArticlePublies();

		return $this->render('home.html.twig', ['articleList' => $articleList]);
	}
}