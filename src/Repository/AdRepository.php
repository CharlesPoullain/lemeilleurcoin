<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/*
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function findHomeAds ($categId = null, $keyword = null) {

        /*
        $dql = "SELECT a FROM App\Entity\Ad a 
        WHERE a.category = :cat 
        ORDER BY a.dateCreated DESC";
        $query = $this->getEntityManager()->createQuery($dql);
       */

        $qb = $this->createQueryBuilder("a");
        if($categId) {
            $qb->andWhere("a.category = :cat");
            $qb->addOrderBy("a.dateCreated", "DESC");

            $qb->setParameter("cat", $categId);
        }

        if($keyword) {
            $qb->andWhere("(a.title LIKE :kw OR a.description LIKE :kw)");
            $qb->setParameter("kw", "%$keyword%");
        }

        $query = $qb->getQuery();

        $query->setMaxResults(50);
        $ads = $query->getResult();

        return $ads;
    }

    public function findUserAds ($userId) {

        /*
        $dql = "SELECT a FROM App\Entity\Ad a
        WHERE a.category = :cat
        ORDER BY a.dateCreated DESC";
        $query = $this->getEntityManager()->createQuery($dql);
       */

        $qb = $this->createQueryBuilder("a");

        $qb->andWhere("a.maker = :user");
        $qb->addOrderBy("a.dateCreated", "DESC");

        $qb->setParameter("user", $userId);

        $query = $qb->getQuery();

        $ads = $query->getResult();

        return $ads;
    }


//    /**
//     * @return Ad[] Returns an array of Ad objects
//     */
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
    public function findOneBySomeField($value): ?Ad
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
