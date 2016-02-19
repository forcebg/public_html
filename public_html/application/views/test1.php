<?php
	
	for ($i = 0; $i < sizeof($list); $i++) {
?>
<p>
	userid : <?=$list[$i]['userid']?> , userpw : <?=$list[$i]['userpw']?>
</p>
<?php
	}
?>

<br />
<br />
<?php
	
	foreach($list as $idx => $item) {
?>
<p>
	<?=$idx?> , userid : <?=$item['userid']?> , userpw : <?=$item['userpw']?>
</p>
<?php
	}
?>