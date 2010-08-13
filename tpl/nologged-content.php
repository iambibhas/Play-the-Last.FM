<div class="post">
                <div id="main-banner">
                          <h3>Hello Stranger!<br />
                          Come.. And</h3> 
                         <h2>Play The <img src="images/lastfm-logo.png" style="border:none;" /></h2>
                </div>
                <div id="toptracks">
                <h3>People are Listening these</h3><br />
                    <?php $topTracks=$userSession->getGeoTopTracks(); 
                        $result="";
                        for($i=0;$i<count($topTracks);$i++){
                            $trackName=urlencode($topTracks[$i]['name']);
                            $artistName=urlencode($topTracks[$i]['artist']['name']);
                            $result=$result . 
                            "<li><a target='_blank' href='track.php?name={$trackName}&artist={$artistName}'>" .
                            "<img width='100px' height='100px' src='{$topTracks[$i]['image'][2]['#text']}' /><br />" .
                            $topTracks[$i]['name'] .
                            "</a></li>";
                        }?>
                        <ul>
                        <?php echo $result; ?>
                        </ul>
                    
                    <pre><?php //print_r($topTracks); ?></pre>
                </div>
            </div>