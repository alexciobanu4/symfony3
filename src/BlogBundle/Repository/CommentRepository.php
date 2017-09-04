<?php
namespace BlogBundle\Repository;
use \Doctrine\ORM\EntityRepository;

class CommentRepository extends \Doctrine\ORM\EntityRepository {

	public function getVerifiedCommentsByEntry($id) {

		$em = $this->getEntityManager();
		
		$query = $em->createQuery("
			SELECT c FROM BlogBundle:Comment c
			WHERE c.active = :active AND c.entry = :entry
			ORDER BY c.id DESC
		")->setParameter("active", "1")
		  ->setParameter("entry", $id);

		$comments = $query->getResult();
		return $comments;
	}

}
