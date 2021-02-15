<?php

namespace  App\Services;

use App\Entity\Articles;
use App\Repository\CategoriesRepository;
use Curl\Curl;

class FakeArticleService
{
	private $categoryRepository;

	public function __construct(CategoriesRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function getFakeArticle()
	{
		$curl = new Curl();
		$article = new Articles();
		$categoriesList = $this->categoryRepository->findAll();
		$catNumber = random_int(2, count($categoriesList));
		$idx = array_rand($categoriesList, $catNumber);
		foreach ($idx as $i) {
			$article->addCategory($categoriesList[$i]);
		}

		$curl->get('http://loripsum.net/api/1/short/plaintext');

		if ($curl->error) {
			throw new \Exception('exception in fake article');
		}
		$titre = $curl->response;
		$titre = substr($titre, 0, 255);
		$article->setTitre($titre);

		$curl->get('http://loripsum.net/api/1/short/plaintext');

		if ($curl->error) {
			throw new \Exception('exception in fake article');
		}
		$soustitre = $curl->response;
		$soustitre = substr($soustitre, 0, 255);
		$article->setSousTitre($soustitre);

		$curl->get('http://loripsum.net/api/1/short/plaintext');

		if ($curl->error) {
			throw new \Exception('exception in fake article');
		}
		$contenu = $curl->response;
		$contenu = substr($contenu, 0, 255);
		$article->setContenu($contenu);

		$article->setPublie(true);
		$article->setDateDePublication(new \DateTime());

		return $article;
	}
}