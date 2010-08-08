<?php

class userSession
{
    
    // method declaration
    public function getSession($token) {
        include 'var.php';  
        $query_string = "";
        $temp_sig="";
        $method_to_call="auth.getSession";
        $temp_sig= "api_key" . $api_key . "method" . $method_to_call . "token" . $token . $secret;
        $api_sig=md5($temp_sig);
        //  -- getSession ---
        $params = array( 
            'token' => $token,
            'api_key'  => $api_key,
            'api_sig'  => $api_sig,
            'method' => $method_to_call,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        echo $url . "<br />";
        $output = file_get_contents($url);
        $temp=get_object_vars(json_decode($output));
        $temp_sess=get_object_vars($temp['session']);
        return $temp_sess;
    }
}
?>