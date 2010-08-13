
<div class="post">
<?php $userInfo = $userSession->getInfo($_GET['name']);
    if(isset($userInfo['error'])){
        echo "<h1>Error No. " . $userInfo['error'] . " : " . $userInfo['message'] . "</h1>";
    }else{
?>
        <h1 class="title">Profile Info : 
        <a href="<?php echo $userInfo['url'] ?>" target="_blank"><?php echo $userInfo['username']; ?></a></h1>
        <div class="entry">
            <p>
                <div id="profile-image"><img src="<?php echo $userInfo['image']; ?>" /></div>
                <div id="profile-desc">
                    <h3><?php echo $userInfo['realname']; ?></h3>
                    <?php echo $userInfo['age'] . " years old " . 
                    $userInfo['gender'] . " from " . $userInfo['country']; ?><br /><br />
                    Member Since <?php echo $userInfo['registered']; ?>.<br />
                    Played <b><?php echo $userInfo['playcount']; ?></b> track(s) since then 
                    and Have <b><?php echo $userInfo['playlists']; ?></b> playlist(s).
                    <pre><?php // print_r($userInfo); ?></pre>
                </div>
            </p>
            <p class="meta">
                <a href="<?php echo $userInfo['url'] ?>" target="_blank">Visit the Profile of 
                <b><?php echo $userInfo['realname']; ?></b> at Last.fm</a></p>
            <p>  <br />
                <h3>Recently Listened Tracks</h3>
                <?php $userRecentTracks= $userSession->getRecentTracks($_GET['name']);  ?>
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
                
            </p>

        <p class="meta">Get <a href="http://www.last.fm/user/<?php echo $userInfo['username']; ?>/tracks"
                             target="_blank">more recent tracks</a> of <?php echo $userInfo['realname']; ?></p>
            <p> <br />
                <h3>Playlists</h3>
                <?php $userPlaylists= $userSession->getPlaylists($_GET['name']);  ?>
                <div id="playlist">
                    <ul>
                        <?php if(!isset($userPlaylists['error'])){ 
                                echo $userPlaylists['content'];
                            ?>
                            
                            <pre><?php //print_r($userPlaylists); ?></pre> 
                        <?php }else{
                            echo $userPlaylists['error'];
                        } ?>
                    </ul>
                </div>
                
            </p>
        </div> 
<?php } ?>
</div>
