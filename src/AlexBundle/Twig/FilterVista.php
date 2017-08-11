<?php  
namespace AlexBundle\Twig;

class FilterVista extends \Twig_Extension {

	public function getFilters() {
		return array(
			new \Twig_SimpleFilter("addText", array($this, 'addText')),
			new \Twig_SimpleFilter("addRandomNumber", array($this, 'addRandomNumber'))
		);
	}

	public function addText($string) {
		return $string . " <strong>texto al final</strong>";
	}

	public function addRandomNumber($string) {
		return $string . " <strong>" . rand(0,99) . "</strong>";
	}

	public function getName() {
		return "filter_vista";
	}

}
?>