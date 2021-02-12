<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Articles::class);
	}

	public function listDesArticlePublies()
	{
		/*
		 * Un article publié => article avec le boolean 'publie' à vrai
		 * ET une date de publication qui est dans le passé.
		 */

		//construction de la requete via le QueryBuilder
		$qb = $this->createQueryBuilder('a');
		$qb->andWhere('a.publie = TRUE');
		$qb->andWhere('a.dateDePublication < CURRENT_TIMESTAMP()');
		$qb->orderBy('a.dateDePublication', 'DESC');
		$qb->setMaxResults(5);

		//récuperation de la requete
		$query = $qb->getQuery();

		//récup du resultat
		$resultat = $query->getResult();

		return $resultat;
	}

	public function getArticlesAvecAuteurs()
	{
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.auteur', 'aut');
		$qb->andWhere('aut.nom = aut');
		$qb->setParameter('nom', 'Briand');

		return $qb->getQuery()->getResult();
	}

	// /**
	//  * @return Articles[] Returns an array of Articles objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('a.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Articles
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}