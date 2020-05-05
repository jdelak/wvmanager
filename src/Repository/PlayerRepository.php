<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findTitulairesPlayers($teamId)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.id_team = :val')
        ->setParameter('val', $teamId)
        ->andWhere('p.squad_position < 8')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findSubstitutePlayers($teamId)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.id_team = :val')
        ->setParameter('val', $teamId)
        ->andWhere('p.squad_position BETWEEN 8 AND 12')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findReservePlayers($teamId)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.id_team = :val')
        ->setParameter('val', $teamId)
        ->andWhere('p.squad_position > 12')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findAvailablePlayers(){
        return $this->createQueryBuilder('p')
        ->andWhere('p.id_team is NULL')
        ->orderBy('p.id', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findLastSquadPlayer($teamId){
        return $this->createQueryBuilder('p')
        ->andWhere('p.id_team = :val')
        ->setParameter('val', $teamId)
        ->orderBy('p.squad_position', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Player[] Returns an array of Player objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
