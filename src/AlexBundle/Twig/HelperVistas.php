<?php 
namespace AlexBundle\Twig;

class HelperVistas extends \Twig_Extension {

	public function getFunctions() {
		return array(
			'generateTable' => new \Twig_Function_Method($this, 'generateTable')
		);
	}

	public function generateTable($resultSet) {

		$table = "<table border=1>";
		for($i=0; $i<count($resultSet); $i++) {
			$table.= "<tr>";
			for($f=0; $f<count($resultSet[$i]); $f++) {
				$resultSet_values = array_values($resultSet[$i]);
				$table.= "<td>".$resultSet_values[$f]."</td>";	
			}
			$table.= "</tr>";
		}
		$table.= "</table>";
		return $table;
	}

	public function getName() {
		return "alex_bundle";
	}

}
?>