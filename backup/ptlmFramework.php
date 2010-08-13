<?php

class userSession
{
    
    // method declaration
    public function getSession($token) {
        include 'var.php';  
        $query_string = "";
        $method_to_call="auth.getSession";
        $api_sig = userSession::getSig($token);
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
        $url=substr_replace($url ,"",-1); // removes the '&' at the end of the string
        $output = file_get_contents($url);
        $temp=get_object_vars(json_decode($output));
        if(isset($temp['session'])){
            $temp_sess=get_object_vars($temp['session']);
            return $temp_sess;
        }else{
            return null;
        }
        
    }
    
    public function getSig($token){
        include 'var.php';
        $temp_sig="";
        $method_to_call="auth.getSession";
        $temp_sig= "api_key" . $api_key . "method" . $method_to_call . "token" . $token . $secret;
        // echo $temp_sig . "<br />";
        $api_sig=md5($temp_sig);
        return $api_sig;
    }
    
    public function getInfo($username){
        include 'var.php';
        $query_string="";
        $method_to_call="user.getInfo";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'user' => $username,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        return $output;
    }
}
?>