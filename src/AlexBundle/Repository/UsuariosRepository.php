<?php

namespace AlexBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * UsuariosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsuariosRepository extends EntityRepository
{
	public function getUsuarios() {
		$em = $this->getManager();
		$query = $em->createQueryBuilder("u")
			->orderBy('u.name', 'ASC')
            ->getQuery();

        $usuarios = $query->getResult();
        return $usuarios;
	}

}
?>