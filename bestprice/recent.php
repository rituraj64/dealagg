<?php require_once 'header.php';?>


<?php
require_once 'model/Search.php';
require_once '../../SmartModel/UI.php';
$searchModel = new Search();
$usersTable=new UI($searchModel,UI::STYLE_LIGHT_GREY);

$usersTable->setActionColumn(array(
		'View'=>array('href'=>'index.php/search/lowest-price-of-{query}/{query_id}'))
);
$usersTable->generate();
?>


<?php
echo  $usersTable->smartUI();
?>
<?php require_once 'footer.php';?>