<?php
include 'var.php';
?>
<html>
<head>
<meta name="generator" content="PhpED Version 5.2 (Build 5220)">
<title>Coded Last.fm to Win</title>
<link rel="shortcut icon"  href="">
</head>
<body>
<pre><?php // print_r($_SERVER); ?></pre>

<?php if($_GET['token']==""){ ?>
<a href="http://www.last.fm/api/auth/?api_key=<?php echo $api_key; ?>">Authorize</a>
<?php }else{ ?>  <!-- User is authorized -->
<pre><?php print_r($_GET); ?></pre>
<?php
$token=$_GET['token'];
$temp_sig="";
$method_to_call="auth.getSession";
$temp_sig= "api_key" . $api_key . "method" . $method_to_call . "token" . $token . $secret;
// echo $temp_sig . "<br />";
$api_sig=md5($temp_sig);
// echo $api_sig;
?>

<?php
$base = 'http://ws.audioscrobbler.com/2.0/';
$query_string = "";
/*  -- getSession ---
$params = array( 
    'token' => $token,
    'api_key'  => $api_key,
    'api_sig'  => $api_sig,
    'method' => $method_to_call
);*/
$method_to_call="user.getInfo";
$params = array( 
    'api_key'  => $api_key,
    'method' => $method_to_call,
    'user' => 'iambibhas',
    'format' => 'json'
);

foreach ($params as $key => $value) {
    $query_string .= "$key=" . urlencode($value) . "&";
}

$url = "$base?$query_string";
$url=substr_replace($url ,"",-1);
echo $url . "<br />";
$output = file_get_contents($url);
$temp=json_decode($output);
?>
<pre><?php print_r($temp); ?> </pre>

<?php } ?>

</body>
</html>