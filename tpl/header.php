<?php
session_start();
include 'ptlmFramework.php';
include 'var.php';
$userSession = &New userSession;

    if(isset($_GET['token']) && !isset($_SESSION['key'])){
        $token=$_GET['token']; 
        $session = $userSession->getSession($token);
        if(isset($session['key'])){
            $_SESSION=$session;
            $_SESSION['token']=$token;
        }else{
            $_SESSION['error']="Invalid Token provided.";
            echo $_SESSION['error'];
        }
    }
    $title="";
    $php_self=explode("/",$_SERVER['PHP_SELF']);
    if($php_self[count($php_self) - 1] == "index.php"){
        $title="Main";
    }else if($php_self[count($php_self) - 1] == "user.php"){
        $title = $_GET['name'] . "'s Profile";
    }else if($php_self[count($php_self) - 1] == "track.php"){
        $title = urldecode(str_replace("+"," ",$_GET['name'])) . " - Track Info";
    }
    
?>
<html>
<head>
<title><?php echo $title; ?> - Play The Last.fm</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="favicon.png" />
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="logo">
            <h1><a href="index.php">Play The <img src="images/lastfm-logo.png" style="border:none;" /></a></h1>
         <?php   if(!isset($_SESSION['key'])){ ?>
            <p id="auth"><a href="http://www.last.fm/api/auth/?api_key=<?php echo $api_key; ?>" title="Authorize from Last.fm">Authorize</a></p>
            <?php }else{ ?>
            <p id="auth">Welcome <a href="user.php?name=<?php echo $_SESSION['name'] ?>" title="Profile Details"><?php echo $_SESSION['name']; ?></a> | <a href="logout.php" title="Logout from this session.">Logout</a></p>
            <?php } ?>
        </div>
    </div>