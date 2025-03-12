<?php
namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 *
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * Recherche les animaux à vendre
     */
    public function findAnimauxAVendre(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.est_a_vendre = :val')
            ->setParameter('val', true)
            ->orderBy('a.date_mise_en_vente', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche les animaux par race
     */
    public function findByRace(int $raceId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.race = :raceId')
            ->setParameter('raceId', $raceId)
            ->getQuery()
            ->getResult();
    }
}