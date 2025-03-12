<?php
namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 *
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    /**
     * Trouve la photo principale d'un animal
     */
    public function findPrincipaleByAnimal(int $animalId): ?Photo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.animal = :animalId')
            ->andWhere('p.est_principale = :estPrincipale')
            ->setParameter('animalId', $animalId)
            ->setParameter('estPrincipale', true)
            ->getQuery()
            ->getOneOrNullResult();
    }
}