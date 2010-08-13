<?php
session_start();
include 'ptlmFramework.php';
include 'var.php';
$userSession = &New userSession;

?>
<html>
<head>
<meta name="generator" content="PhpED Version 5.2 (Build 5220)">
<title>Play The Last.fm</title>
<link rel="shortcut icon"  href="">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div id="header">
<?php
    if(isset($_GET['token']) && !isset($_SESSION['key'])){
        $token=$_GET['token']; 
        $session = $userSession->getSession($token);
        if(isset($session['key'])){
            $_SESSION=$session;
            $_SESSION['token']=$token;
        }else{
            echo "Invalid Token provided.";
        }
    }
    if(!isset($_SESSION['key'])){ ?>
<div id="auth"><a href="http://www.last.fm/api/auth/?api_key=<?php echo $api_key; ?>">Authorize</a></div>
<?php

    } ?>  <!-- User is authorized -->
</div>
<?php
if(isset($_SESSION['key'])){
$username=$_SESSION['name'];

print_r($_SESSION);

$userInfo = $userSession->getInfo($username);

?>

<pre><?php print_r($userInfo); ?> </pre>
<a href="logout.php">Logout</a>

<?php } ?>
</body>
</html>