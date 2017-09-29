<?php  

namespace BlogBundle\Manager;

use BlogBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;


class CategoryManager {

	private $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function guardar(Category $category)
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    public function borrar(Category $category)
    {
        $this->em->remove($category);
		$this->em->flush();
    }

}
?>