<div class="post">
<?php $userInfo= $userSession->getInfo($_SESSION['name']); ?>
                <h1 class="title">Hi <?php echo $userInfo['realname']; ?>!</h1>
                <div class="entry">
                    <p>
                        Welcome!<br />Hang around a bit.. Or you can visit <a target="_blank" href="<?php echo $userInfo['url']; ?>">your Last.fm page</a>..
                        <pre><?php  
                         //print_r($userInfo); print_r($_SESSION); ?></pre>
                    </p>
                </div>
                    <p>  <br />
                <h3>Here are some tracks you've recently listened..</h3>
                <?php $userRecentTracks= $userSession->getRecentTracks($_SESSION['name']);  ?>
                <div id="tracklist">
                    <ul>
                        <?php if(!isset($userRecentTracks['error'])){ 
                                echo $userRecentTracks['content'];
                            ?>
                            <pre><?php //print_r($userRecentTracks); ?></pre> 
                        <?php }else{
                            echo $userRecentTracks['error'];
                        } ?>
                    </ul>
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
            </p>
</div>