<?php

namespace App\Repository;

use App\Entity\Meeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meeting::class);
    }


    public function findMeetingPast($date)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.date < :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function findLast()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findMeetingToday($date)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.date = :date')
            ->andWhere('m.end < :heure')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('heure', $date->format('H:i:s'))
            ->getQuery()
            ->getResult();
    }

    public function findPart($date, $id)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.users', 'm')
            ->addSelect('m')
            ->andWhere('u.id = :id')
            ->andWhere('u.date = :date')
            ->andWhere('m.admin = 0')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findP($id)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.users', 'm')
            ->addSelect('m')
            ->andWhere('u.id = :id')
            ->andWhere('m.admin = 0')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findParticipants($id)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.users', 'm')
            ->addSelect('m')
            ->andWhere('u.id = :id')
            ->andWhere('m.admin = 0')
            ->andWhere('m.present = 1')
            ->andWhere('u.present = 1')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function findIn($id, $date)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.users', 'm')
            ->addSelect('m')
            ->andWhere('u.id = :id')
            ->andWhere('u.end >= :deb')
            ->andWhere('u.beginning <= :fin')
            ->andWhere('u.date = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('deb', $date->format('H:i:s'))
            ->setParameter('fin', $date->format('H:i:s'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findbefore($id, $date)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.users', 'm')
            ->addSelect('m')
            ->andWhere('u.id = :id')
            ->andWhere('u.beginning > :fin')
            ->andWhere('u.end > :fin')
            ->andWhere('u.date = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('fin', $date->format('H:i:s'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findafter($id, $date)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.users', 'm')
            ->addSelect('m')
            ->andWhere('u.id = :id')
            ->andWhere('u.end < :fin')
            ->andWhere('u.date = :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('fin', $date->format('H:i:s'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Meeting
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
