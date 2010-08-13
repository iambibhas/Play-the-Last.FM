<?php
    
    include 'tpl/countrylist.php';
    $country_list = countryArray();
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
        global $country_list;
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
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=get_object_vars($output);
        if(!isset($details_array['error'])){
            $temp_user=get_object_vars($details_array['user']);
            $temp_image = get_object_vars($temp_user['image'][1]);
            $gender = ($temp_user['gender']=="m") ? "Male" : "Female" ;

            $registered = get_object_vars($temp_user['registered']);
            
            $user = Array (
                'username' => $temp_user['name'], 
                'realname' => $temp_user['realname'],
                'image' => $temp_image['#text'],
                'url' => $temp_user['url'],
                'country' => $country_list[$temp_user["country"]],
                'age' => $temp_user['age'],
                'gender' => $gender,
                'playcount' => $temp_user['playcount'],
                'playlists' => $temp_user['playlists'],
                'registered' => date("jS M, Y", $registered['unixtime'])
                );
            return $user;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function getRecentTracks($username){
        include 'var.php';
        $query_string="";
        $method_to_call="user.getRecentTracks";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'user' => $username,
            'limit' => 10,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=get_object_vars($output);
        $user=userSession::getInfo($username);
        if($user['playcount']>0){                       // $details_array['track'] is empty
            $temp1 = get_object_vars($details_array['recenttracks']);
            if(isset($temp1['track'])){
                if($user['playcount']==1){                  // When the count is one, ['track'] is not an array, Hence ..
                    $temp_tracks=get_object_vars($temp1['track']);
                    $result=userSession::processTrack($temp_tracks);
                    $tracks['content']=$result;
                    return $tracks;
                }else{                                      // Array.. Processing..
                    $temp_tracks=$temp1['track'];
                    $result="";
                    for($i=0;$i<count($temp_tracks);$i++){
                        $result=$result . userSession::processTrack(get_object_vars($temp_tracks[$i]));
                    }
                    $tracks['content']=$result;
                    return $tracks;
                }
            }else{
                $tracks = Array (
                    'error' => "<li>No recent tracks found.</li>"
                );
                return $tracks;
            }
        }else{
            $tracks = Array (
                'error' => "<li>No recent tracks found.</li>"
            );
            return $tracks;
        }
        
    }
    
    public function getPlaylists($username){
        include 'var.php';
        $query_string="";
        $method_to_call="user.getPlaylists";
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
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=get_object_vars($output);
        $playlists=get_object_vars($details_array['playlists']);
        $processedPlaylist="";
        $user=userSession::getInfo($username);
        if($user['playlists']>0){      // $details_array['track'] is empty
            if($user['playlists']==1){
                $playlist=get_object_vars($playlists['playlist']);
                $image = get_object_vars($playlist['image'][2]);
                $final_playlists=Array(
                    'id' => $playlist['id'],
                    'title' => $playlist['title'],
                    'description' => $playlist['description'],
                    'size' => $playlist['size'],
                    'duration' => $playlist['duration'],
                    'url' => $playlist['url'],
                    'image' => $image['#text']
                );
                $processedPlaylist= userSession::processPlaylist($final_playlists);
                $final_playlists['content']=$processedPlaylist;
            }else{
                $playlist=$playlists['playlist'];
                for($i=0;$i<$user['playlists'];$i++){
                    $temp_playlist= get_object_vars($playlist[$i]);
                    $image = get_object_vars($temp_playlist['image'][1]);
                    $final_playlists[$i]=Array(
                        'id' => $temp_playlist['id'],
                        'title' => $temp_playlist['title'],
                        'description' => $temp_playlist['description'],
                        'size' => $temp_playlist['size'],
                        'duration' => $temp_playlist['duration'],
                        'url' => $temp_playlist['url'],
                        'image' => $image['#text']
                    );
                    $processedPlaylist = $processedPlaylist . userSession::processPlaylist($final_playlists[$i]);
                    
                } 
                //$final_playlists=$playlist;
                $final_playlists['content']=$processedPlaylist;
            }                       
            
        }else{
            $final_playlists = Array (
                'error' => "<li>No playlist found.</li>"
            );
        }
        return $final_playlists;
    }
    
    public function getShoutNo($username){
        include 'var.php';
        $query_string="";
        $method_to_call="user.getShouts";
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
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=get_object_vars($output);
        $shouts=get_object_vars($details_array['shouts']);
        return get_object_vars($shouts['@attr']);
    }
    
    public function getFriendNo($username){
        include 'var.php';
        $query_string="";
        $method_to_call="user.getFriends";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'user' => $username,
            'limit' => 1,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=get_object_vars($output);
        //return get_object_vars($details_array['friends']);
        return $details_array;
    }
    
    public function getTrackInfo($trackName,$artist){
        include 'var.php';
        $query_string="";
        $method_to_call="track.getInfo";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'track' => $trackName,
            'artist' => $artist,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=get_object_vars($output);
        if(!isset($details_array['error'])){
            $track=get_object_vars($details_array['track']);
            $album=get_object_vars($track['album']);
            $image=get_object_vars($album['image'][1]);
            $result=Array(
                'name' => $track['name'],
                'url' => $track['url'],
                'duration' => ($track['duration']/1000),
                'scrobbles' => $track['playcount'],
                'listeners' => $track['listeners'],
                'albumName' => $album['title'],
                'albumImage' => $image['#text']
            );
            return $result;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function getTrackBuyLink($trackName,$artist){
        include 'var.php';
        $query_string="";
        $method_to_call="track.getBuylinks";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'track' => $trackName,
            'artist' => $artist,
            'country' => 'united kingdom',
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=userSession::object_to_array($output);
        if(!isset($details_array['error'])){
            $physical=$details_array['affiliations']['physicals']['affiliation'];
            $download=$details_array['affiliations']['downloads']['affiliation']; 
            $result=Array(
                'physicals' => $physical,
                'download' => $download
            );
            return $result;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function getAlbumBuyLink($album,$artist){
        include 'var.php';
        $query_string="";
        $method_to_call="album.getBuylinks";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'album' => $album,
            'artist' => $artist,
            'country' => 'united kingdom',
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=userSession::object_to_array($output);
        if(!isset($details_array['error'])){
            $physical=$details_array['affiliations']['physicals']['affiliation'];
            $download=$details_array['affiliations']['downloads']['affiliation']; 
            $result=Array(
                'physicals' => $physical,
                'download' => $download
            );        
            
            return $result;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function getArtistInfo($artist){
        include 'var.php';
        $query_string="";
        $method_to_call="artist.getInfo";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'artist' => $artist,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=userSession::object_to_array($output);
        if(!isset($details_array['error'])){
            $result=$details_array['artist'];
            return $result;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function getAlbumInfo($album,$artist){
        include 'var.php';
        $query_string="";
        $method_to_call="album.getInfo";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'album' => $album,
            'artist' => $artist,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=userSession::object_to_array($output);
        if(!isset($details_array['error'])){
            $result=$details_array['album'];
            return $result;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function getArtistShouts($artist){
        include 'var.php';
        $query_string="";
        $method_to_call="artist.getShouts";
        $params = array( 
            'api_key'  => $api_key,
            'method' => $method_to_call,
            'artist' => $artist,
            'limit' => 5,
            'format' => 'json'
        );

        foreach ($params as $key => $value) {
            $query_string .= "$key=" . urlencode($value) . "&";
        }

        $url = "$base?$query_string";
        $url=substr_replace($url ,"",-1);
        // echo $url . "<br />";
        $temp = file_get_contents($url);
        $output=json_decode($temp);
        $details_array=userSession::object_to_array($output);
        if(!isset($details_array['error'])){
            $result=$details_array['artist'];
            return $result;
        }else{
            $user = Array (
                'error' => $details_array['error'],
                'message' => $details_array['message']
            );
            return $user;
        }
    }
    
    public function object_to_array($data)       // Converts a Nested stdObject to a full associative Array
        {                                           // Not used everywhere, because found this solution much later
          if(is_array($data) || is_object($data))      //
          {
            $result = array(); 
            foreach($data as $key => $value)
            { 
              $result[$key] = userSession::object_to_array($value); 
            }
            return $result;
          }
          return $data;
        }

    
    function processPlaylist($singlePlaylist){
        $result = "<li>" .
                    "<a href='" . $singlePlaylist['url'] . "' target='_blank'><img src='" . 
                    $singlePlaylist['image'] . "' />" .
                    "<h3>" . 
                    $singlePlaylist['title'] . "</a></h3><i>'" .
                    $singlePlaylist['description'] . "'</i><br /><br />" .
                    "Total " . $singlePlaylist['size'] . " track(s)<br />" . 
                    "Duration : " . floor($singlePlaylist['duration']/60) . ":" . ($singlePlaylist['duration']%60) .
                    "</li>";
        return $result;
    }
    
    function processTrack($track){
        $temp1_track=get_object_vars($track['artist']);
        $temp1_album=get_object_vars($track['album']);
        $temp2_track = Array(
            'artist' => str_replace(" ", "+", urlencode($temp1_track['#text'])),
            'name' => str_replace(" ", "+", urlencode($track['name'])),
            'album' => str_replace(" ", "+", urlencode($temp1_album['#text']))
        );
        $result="<li>" . 
                "<a href='track.php?name=" . 
                $temp2_track['name'] . "&artist=" . $temp2_track['artist'] . "'>" . $track['name'] . "</a> - " . 
                "<a href='artist.php?name=" . 
                $temp2_track['artist'] . "'>" . $temp1_track['#text'] . "</a> | Album : " . 
                "<a href='album.php?name=" . 
                $temp2_track['album'] . "&artist=" . $temp2_track['artist'] . "'>" . $temp1_album['#text'] . "</a>" .
                "</li>";
        return $result;
    }
}
?>