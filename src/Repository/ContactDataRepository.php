<?php

namespace App\Repository;
use App\Entity\ContactData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactData[]    findAll()
 * @method ContactData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactData::class);
    }
}