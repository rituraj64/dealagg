<?php
date_default_timezone_set('Asia/Calcutta');
require_once 'Parsing.php';
if(isset($_REQUEST['q'])){
	$query = urlencode($_REQUEST['q']);
	$query2 = urldecode($_REQUEST['q']);
	$subcat = $_REQUEST['subcat'];

	$cat = false;
	if(isset($_REQUEST['cat'])){
		$cat = $_REQUEST['cat'];
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['prev_cat'] = $cat;
	}
	$cache = 1;
	$max = 0;
	$parsing = new Parsing();
	$data = array();
	$ajaxParseSite = array();
	$errorSites = array();
	$emptySites = array();
	$delay = true;
	$sites = $parsing->getWebsites();

	if(isset($_REQUEST['cache'])){
		$cache = $_REQUEST['cache'];
	}

	$query_id = '';
	if(isset($_REQUEST['site'])){
		$delay = false;
		$site = urldecode($_REQUEST['site']);
		$sites = array($site);
	}else{
		$query_id = md5($query2.time());
		require_once 'model/Search.php';
		$searchModel = new Search();
		$searchModel->setQuery($query2);
		$searchModel->setCategory($cat);
		$searchModel->setSubcat($subcat);
		$searchModel->query_id = $query_id;
		$searchModel->created_at = time();
		$searchModel->setHits(0);
		$searchModel->insert();
	}
	$untrusted = array();

	//	$sites = array('Flipkart');
	foreach($sites as $site){
		require_once 'Sites/'.$site.'.php';
		$siteObj = new $site;
		if($siteObj->allowCategory($cat)){
			$trust = $siteObj->isTrusted($cat);
			if(isset($_REQUEST['site'])){
				$trust = true;
			}
			if($trust){
				try{
					$data1 = $siteObj->getPriceData($query,$cat,$subcat,$delay,$cache);
					$resultTime = $siteObj->getResultTime();
					if($resultTime > $max){
						$max = $resultTime;
					}
					if(!$data1 && $delay){
						$ajaxParseSite[] = array('site'=>$site,'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
					}else{
						$data2 = array();
						$count = 0;
						foreach($data1 as $row){
							$name = $row['name'];
							$row['logo'] = $siteObj->getLogo();
							$row['searchurl'] = $siteObj->getSearchURL($query,$cat,$subcat);

							$data2[] = $row;
							$count++;
						}
						$data1 = array();
						//uasort($data2, 'priceSort');

						if(empty($data2)){
							$emptySites[] = array('site'=>$site,'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
						}else{
							if(empty($data)){
								$data = $data2;
							}else{
								$data = array_merge($data,$data2);
							}
						}
					}
				}catch(Exception $e){
					$errorSites[] = array('site'=>$site,'message'=>$e->getMessage(),'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
				}
			}else{
				$untrusted[] = array('site'=>$site,'searchurl'=>$siteObj->getSearchURL($query,$cat,$subcat),'logo'=>$siteObj->getLogo());
			}
		}
	}
	$site = '';
	if(isset($_REQUEST['site'])){
		$site = $_REQUEST['site'];
		$data2 = array();
		$i=0;
		foreach($data as $r){
			if($i >= Parsing::DATA_NUM){
				break;
			}
			$data2[] = $r;
			$i++;
		}
		$data = $data2;
	}else if(isset($data[0])){

		$index = 0;
		$prev_website = $data[0]['website'];
		$score = array();
		foreach($data as $row){
			$website = $row['website'];
			$name = $row['name'];

			if($website != $prev_website){
				$prev_website = $website;
				$index = 1;
			}else{
				$index++;
			}

			$defscore = Parsing::DATA_NUM + 1 - $index;
			$defscore = 0;

			for($i=0;$i<sizeof($score);$i++){
				if($score[$i]['website'] != $website){
					$name_new = $score[$i]['name'];
					$website_new = $score[$i]['website'];
					$score_new = $score[$i]['score'];

					$name_new_comp = $name_new;
					$name_comp = $name;
					$par = Parsing::getReplace();
					foreach($par as $key => $value){
						if(strpos($name_new_comp, $key) !== false){
							$name_new_comp = str_replace($key, $value, $name_new_comp);
						}
						if(strpos($name_comp, $key) !== false){
							$name_comp = str_replace($key, $value, $name_comp);
						}
					}
					if(strtolower($name_new_comp) == strtolower($name_comp)){

						//$defscore += $score_new;
						//$score_new += $defscore;
						$score[$i]['score'] = $score_new + 1;
						$defscore = $score_new + 1;

					}
				}
			}
			$score[] = array('website'=>$website,'name'=>$name,'score'=>$defscore);
		}

		$score2 = array();
		foreach($score as $r){
			if(!isset($score2[$r['website']])){
				$score2[$r['website']] = array();
			}
			$score2[$r['website']][] = array('name'=>$r['name'],'score'=>$r['score']);
		}
		$data2 = array();
		foreach($data as $row){
			$website = $row['website'];
			$name = $row['name'];
			if(!isset($data2[$website])){
				$data2[$website] = array();
			}
			$name = $row['name'];
			$score = 0;
			foreach($score2[$website] as $r){
				if($r['name'] == $name){
					$score = $r['score'];
					$row['score'] = $score;
				}
			}
			$data2[$website][] = $row;
		}
		foreach($data2 as $website => $rows){
			uasort($rows, 'scoreSort');
			$data2[$website] = $rows;
		}

		$data = array();
		foreach($data2 as $website => $rows){
			$i = 0;
			foreach($rows as $r){
				if($i >= Parsing::DATA_NUM){
					break;
				}
				$data[] = $r;
				$i++;
			}
		}
	}
	$return = array('untrusted'=>$untrusted,'query_id'=>$query_id,'ajax_parse'=>$ajaxParseSite,'data'=>$data,'result_time'=>date('d/m/y h:i a',$max),'result_number_time'=>$max,'error_sites'=>$errorSites,'empty_sites'=>$emptySites,'site'=>$site);
	if(!isset($_REQUEST['silent'])){
		if(isset($_GET['callback'])){
			echo $_GET['callback'] . '(' . json_encode($return) . ')';
		}else{
			echo json_encode($return);
		}
	}
}
function scoreSort($a,$b){
	return $a['score'] <= $b['score'];
}
function priceSort($a,$b){
	if ($a['disc_price'] == $b['disc_price']) {
		return 0;
	}
	return ($a['disc_price'] < $b['disc_price']) ? -1 : 1;
}
function longest_common_substring($words)
{
	$words = array_map('strtolower', array_map('trim', $words));
	$sort_by_strlen = create_function('$a, $b', 'if (strlen($a) == strlen($b)) { return strcmp($a, $b); } return (strlen($a) < strlen($b)) ? -1 : 1;');
	usort($words, $sort_by_strlen);
	// We have to assume that each string has something in common with the first
	// string (post sort), we just need to figure out what the longest common
	// string is. If any string DOES NOT have something in common with the first
	// string, return false.
	$longest_common_substring = array();
	$shortest_string = str_split(array_shift($words));
	while (sizeof($shortest_string)) {
		array_unshift($longest_common_substring, '');
		foreach ($shortest_string as $ci => $char) {
			foreach ($words as $wi => $word) {
				if (!strstr($word, $longest_common_substring[0] . $char)) {
					// No match
					break 2;
				} // if
			} // foreach
			// we found the current char in each word, so add it to the first longest_common_substring element,
			// then start checking again using the next char as well
			$longest_common_substring[0].= $char;
		} // foreach
		// We've finished looping through the entire shortest_string.
		// Remove the first char and start all over. Do this until there are no more
		// chars to search on.
		array_shift($shortest_string);
	}
	// If we made it here then we've run through everything
	usort($longest_common_substring, $sort_by_strlen);
	return array_pop($longest_common_substring);
}
?>