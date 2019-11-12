


<div id="wrapper">
    <div id="header">
        <h1>Forum</h1>
    </div>
	<style>
        body  {

            background-color: #cccccc;
        }
    </style>

<div id="subnavigation" style="float:left; width:20%;">
<ul>
		<li><a href="index.php?content=forum&subnav=home2"> Home</a></li>
		<li><a href="index.php?content=forum&subnav=t_erst"> Create a topic</a></li>
		<li><a href="index.php?content=forum&subnav=k_erst"> Create a category</a></li>
       </ul>
</div>

<div id="content" style="float:right; width:80%;">
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
	

}

?>

</div> 
