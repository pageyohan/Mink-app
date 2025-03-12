<?php
namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Race>
 *
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }

    /**
     * Recherche les races par type d'animal
     */
    public function findByTypeAnimal(int $typeId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.typeAnimal = :typeId')
            ->setParameter('typeId', $typeId)
            ->orderBy('r.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}