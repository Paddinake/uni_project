<?php
    $currentURL = "index.php?content=analysen&symbol=". $_GET["symbol"];
?>

<div id="searchbar">
    <?php
    include "searchbar.php";
    ?>
</div>
<br>

<div id="navigation-analysen" style="float: left;width: 20%; background-color: green;">
    <ul>
        <li><a href="<?php echo $currentURL."&subanalyse=aktienkurs" ?> ">Aktienkurs</a></li>
        <li><a href="">ka 2. Graph</a></li>
        <li><a href="">ka 3. Graph</a></li>
    </ul>
</div>


<div id="content-analysen" style="float:right; width:80%; background-color: lightblue;">
    <?php


    if (isset($_GET["subanalyse"])){
        $subanalyse = $_GET["subanalyse"];
        if ($subanalyse == "aktienkurs"){
            include "aktienkurs.php";
        }
    } else {
        include "uebersicht.php";
    }



    ?>


</div>
