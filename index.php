<?php
?>

<head>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>Aktien</title>
</head>
<body>
<div>
    <div id="header">
        <h1>Aktien</h1>
    </div>
    <div class="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?content=login">Login</a></li>
            <li><a href="index.php?content=overview">Übersicht</a></li>
            <li><a href="index.php?content=forum">Forum</a></li>
            <li><a href="index.php?content=register">Registrieren</a></li>
            <li><a href="index.php?content=settings">Einstellungen</a></li>
            <li><a href="index.php?content=test">test</a></li>

        </ul>
    </div>
    <div class="content">
        <?php
        $content=(isset($_GET['content']))?$_GET['content']:'home';
        switch($content){
            case "login":
                include 'content/login/login.php';
                break;
            case "overview":
                include 'content/overview/overview.php';
                break;
            case "forum":
                include 'content/forum/forum.php';
                break;
            case "register":
                include 'content/register/register.php';
                break;
            case "settings":
                include 'content/settings/settings.php';
                break;
            case "test":
                include 'content/login/test.php';
                break;
            Default:
                include 'content/home/home.php';
        }
        ?>
    </div>
    <div class="clear">
    </div>
    <div id="footer">
        &copy; Yorrick, Hagen, Patrick
    </div>
</div>
</body>
</html>