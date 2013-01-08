<?php
set_time_limit(300000);
require_once 'Parsingcoupon.php';
require_once 'phpMailer/class.phpmailer.php';
require_once 'phpMailer/class.smtp.php';


$proxy_list = 'http://www.hidemyass.com/proxy-list/search-691734';
$parser = new Parser();
$parser->_noProxy = true;
$html = $parser->getHtml($proxy_list);
phpQuery::newDocumentHTML($html);
echo $html;die;
foreach(pq('#listtable')->find('tr') as $tr){
	$ip = pq($tr)->children('td:eq(1)');
	echo pq($ip)->html();
}