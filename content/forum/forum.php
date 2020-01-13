<?php
if (!isset($_SESSION["user_id"])) {
    header('Location: index.php');
}
?>

<div class="container-fluid padding" >
    <?php
    if (isset($_GET['subnav'])){
        $content = $_GET['subnav'];
        if ($content=="overview"){
            include "overview.php";
        }
        if ($content=="createTopic"){
            include "createTopic.php";
        }
        if ($content=="createCategory"){
            include "createCategory.php";
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
        include "overview.php";
    }

    ?>

</div> 

