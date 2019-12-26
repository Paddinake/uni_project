<div class="container-fluid padding" >
<?php 
if (isset($_GET['subnav'])){
	$content = $_GET['subnav'];
	if ($content=="home2"){
		include "home2.php";
	}
	if ($content=="t_erst"){
		include "t_erst.php";
	}
	if ($content=="k_erst"){
		include "k_erst.php";
	}
	if ($content=="topics"){
		include "topics.php";
	}
	if ($content=="category"){
		include "category.php";
	}
	if ($content=="reply"){
		include "reply.php";
	}
} else {
	include "home2.php";
}

?>

</div> 

