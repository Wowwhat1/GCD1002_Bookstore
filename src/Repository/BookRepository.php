<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\ORM\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function add(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager
        ()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMore($search): Query
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('p')
            ->from('App:Book', 'p');
        if (!(is_null($search) || empty($search))) {
            $qb->andWhere('p.Title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        // returns an array of Product objects
        return $qb->getQuery();
    }

    public function findInfoBook($idBook):Query
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('b')
            ->from('App:Book', 'b')
            ->where('b.Title =' . $idBook);
        return $qb->getQuery();
    }

        /**
         * @return Book[] Returns an array of Book objects
         */
        public function filter($min, $max, $cat): array
        {
            $entityManager = $this->getEntityManager();
            $qb = $entityManager->createQueryBuilder();
            $qb->select('b')
                ->from('App\Entity\Book', 'b')
                ->where('b.Cost >= 0    ');
            if ($min != NULL) {
                $qb->andWhere('b.Cost >=' . $min);
            }
            if ($max != NULL) {
                $qb->andWhere('b.Cost <=' . $max);
            }
            if ($cat != NULL && $cat!= 0) {
                $qb->andWhere('b.Category =' .$cat);
            }

            // returns an array of Product objects
            return $qb->getQuery()->getResult();
        }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
