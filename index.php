<?php
	include("majik.php");

	header("Content-type: image/jpg");



	$m = new MajikBox();
	$m->loadEffects("effects");

	$i = new Imagick('test.jpg');


	//$i = $m->enrich($i);
	//$i = $m->autocolor($i);
	//$i = $m->autotone($i);

	$i = $m->toycamera($i);
	
	echo $i;
?>
