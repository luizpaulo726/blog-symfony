<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Busca posts filtrando por texto (título/resumo/conteúdo) e status.
     *
     * @return Post[]
     */
    public function buscar(?string $termo = null, ?string $status = null): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.autor', 'a')
            ->addSelect('a')
            ->orderBy('p.criadoEm', 'DESC');

        if ($termo !== null && trim($termo) !== '') {
            $qb->andWhere('p.titulo LIKE :termo OR p.resumo LIKE :termo OR p.conteudo LIKE :termo')
               ->setParameter('termo', '%' . trim($termo) . '%');
        }

        if ($status === 'publicado') {
            $qb->andWhere('p.publicado = true');
        } elseif ($status === 'rascunho') {
            $qb->andWhere('p.publicado = false');
        }

        return $qb->getQuery()->getResult();
    }
}
