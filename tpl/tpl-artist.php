
<div class="post">
<?php $artistInfo = $userSession->getArtistInfo($_GET['name']);
    if(isset($artistInfo['error'])){
        echo "<h1>Error No. " . $artistInfo['error'] . " : " . $artistInfo['message'] . "</h1>";
    }else{ 
?>
        <div class="entry">
           <pre><?php // print_r($artistInfo); ?> </pre>
            <p>
                <div id="artist-image"><img src="<?php echo $artistInfo['image'][2]['#text']; ?>" /></div>
                <div id="track-desc">
                    <h2><a href="<?php echo $artistInfo['url']; ?>"><?php echo $artistInfo['name']; ?></a></h2>
                    <div id="left-cont" >
                        <h2><?php echo $artistInfo['stats']['playcount']; ?></h2>
                        Plays
                    </div>
                    <div id="right-cont" >
                        <h2><?php echo $artistInfo['stats']['listeners']; ?></h2>
                        Listeners
                    </div>
                </div>
            </p>

            <p>
                <h2 align="center">Like <?php echo $artistInfo['name']; ?>? Listen to these people then..</h2>
                <div id="tracklist"><br />
                <?php 
                    $output = "";
                    $similarArtistList=$artistInfo['similar']['artist'];
                    $artistName="";
                    if(is_array($similarArtistList)){
                    for($i=0;$i<count($similarArtistList);$i++){
                        $artistName=urlencode($similarArtistList[$i]['name']);
                        $output = $output . 
                        "<li><a href='artist.php?name={$artistName}'>" . 
                        $similarArtistList[$i]['name'] . "</a> - <a target='_blank' href='{$similarArtistList[$i]['url']}'>Last.fm link</a></li>";
                    }
                    }else{
                        $artistName=urlencode($similarArtistList['name']);
                        $output = $output . 
                        "<li><a href='artist.php?name={$artistName}'>" . 
                        $similarArtistList['name'] . "</a> - <a target='_blank' href='{$similarArtistList['url']}'>Last.fm link</a></li>";
                    }  ?>
                        <h3>Similar Artists</h3>
                         <ul>
                    <?php
                    echo $output;
                    ?> 
                        </ul>
                        <h3>Tags</h3>
                        <?php
                        $outputTag = "";
                        $artistTag=$artistInfo['tags']['tag'];
                        if(is_array($artistTag)){
                            for($i=0;$i<count($artistTag);$i++){
                                $outputTag = $outputTag . 
                                "<span id='tags'><a href='tag.php?tag={$artistTag[$i]['name']}'>" . 
                                $artistTag[$i]['name'] . 
                                "</a></span>&nbsp;";
                            } 
                        }else{
                            $outputTag = $outputTag . 
                                "<span id='tags'><a href='tag.php?tag={$artistTag['name']}'>" . 
                                $artistTag['name'] . 
                                "</a></span>&nbsp;";
                        } ?>
                        <ul>
                    <?php
                    echo $outputTag;
                    ?> 
                        </ul>
                        
                        <h3>Biography</h3>
                        <div id="artist-bio">
                            <pre width="80"><?php if(isset($artistInfo['bio']['content'])){
                                echo $artistInfo['bio']['content']; 
                            }else{
                                echo "No details found";
                            }?></pre>
                        </div>
                <pre><?php //print_r($trackBuyLink); ?> </pre>  
                </div>                    
            </p>
        </div> 
<?php } ?>
</div>
