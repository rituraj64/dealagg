<?php
class Sorting {
	public function sort($query,$data){
		return $data;
		
		/*
		 echo '<pre>';
		$data2 = array();
		for($i=0;$i<sizeof($data); $i++){
		for($j=0;$j<sizeof($data); $j++){
		if($i == $j || !isset($data[$i]) || !isset($data[$j])){
		continue;
		}
		if($data[$i]['name'] == $data[$j]['name']){
		if($data[$i]['disc_price'] < $data[$j]['disc_price']){
		unset($data[$j]);
		}else{
		unset($data[$i]);
		}
		}
		}
		}
		$avg = 0;
		$corData = array();
		for($i=0;$i<sizeof($data); $i++){
		for($j=$i;$j<sizeof($data); $j++){
		if($i == $j || !isset($data[$i]) || !isset($data[$j])){
		continue;
		}
		$cor = $this->findCorrelation($data[$i],$data[$j]);
		$avg = $avg + $cor[1];
		$avg = $avg/2;
		$corData[] = array('cor'=>$cor,'row1'=>$data[$i],'row2'=>$data[$j]);
		}
		}
		foreach($corData as $r){
		$cor = $r['cor'];
		$row1 = $r['row1'];
		$row2 = $r['row2'];
		if($cor[1] > $avg){
		echo 'N1 '.$row1['name'].'<br/>';
		echo 'P1 '.$row1['disc_price'].'<br/>';
		echo 'N2 '.$row2['name'].'<br/>';
		echo 'P2 '.$row2['disc_price'].'<br/>';
		print_r($cor);
		echo '<br/>';echo '<br/>';echo '<br/>';
		}
		}
		echo $avg;
		die;

		echo '<pre>';
		print_r($data);die;
		*/
		return $data;
	}
	public function findCorrelation($row1,$row2){
		$name1 = $row1['name'];
		$name2 = $row2['name'];
		$disc_price1 = $row1['disc_price'];
		$disc_price2 = $row2['disc_price'];
		$disc_price_diff = -1;
		if($disc_price1 != 0){
			$disc_price_diff = abs($disc_price1 - $disc_price2)/($disc_price1) * 100;
		}

		//$name1 = explode(" ", $name1);
		//$name2 = explode(" ", $name2);

		$name_match = 0;

		$len = strlen($name1);
		if($len < strlen($name2)){
			$len = strlen($name2);
		}

		for($i=0;$i<$len;$i++){
			if(isset($name1[$i]) && isset($name2[$i])){
				if($name1[$i] == $name2[$i]){
					$name_match++;
				}else{
					break;
				}
			}
		}
		//$len = sizeof($name1) > sizeof($name2) ? sizeof($name1) : sizeof($name2);
		//$name_match = $name_match/$len;

		return array($disc_price_diff,$name_match);
	}
}