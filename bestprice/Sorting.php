<?php
class Sorting{
	public function sort($array,$query) {
		$input = explode(' ', $query);
		$max = max(array_map('strlen',$input));
		$reg = array();
		for($m=0;$m<$max;$m++){
			$reg[$m]="";
			for($ia=0;$ia<count($input);$ia++){
				if(isset($input[$ia][$m])){
					$reg[$m].=$input[$ia][$m];
				}
			}
		}

		$sort = array();
		foreach($array as $result){
			$matches = 0;
			$resultStrs = explode(' ',$result);
			foreach($resultStrs as $r){
				$strlen = strlen($r);
				for($p=0;$p<$strlen;$p++){
					if($reg[$p])
						echo $reg[$p].'xxx'.$r[$p].'<br/>';
					preg_match('/^['.$reg[$p].']/i',$r[$p],$match);
					if($match==true){
						echo 'match<br/>';
						$matches ++;
					} else {
						break 2;
					}
				}
			}
			$sort[$result] = $matches;
		}
		print_r($sort);
		asort($sort);
		$sort = array_reverse(array_keys($sort));
		return $sort;
	}
}
$query  = 'samsung galaxy s';
$results = array('praveen pandey','praveen kumar','pandey praveen','kumar samsung');
$sort = new Sorting();
$r = $sort->sort($results,$query);
print_r($r);
