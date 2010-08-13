
<div class="post">
<?php $tagDetails = $userSession->getSimilarTag($_GET['tag']);
    if(isset($tagDetails['error'])){
        echo "<h1>Error No. " . $tagDetails['error'] . " : " . $tagDetails['message'] . "</h1>";
    }else{
?>
        <pre><?php //print_r($tagDetails); ?></pre>
        <h1 class="title">Tag : <?php echo $_GET['tag']; ?></h1>
        <div class="entry">
            <p>
            <div id="similar-tags>">
                <h3>Similar Tags</h3><br />
                <?php
                    $output="";
                    $tag="";
                    for($i=0;$i<5;$i++){
                        $tag=urlencode($tagDetails[$i]['name']);
                        $output=$output . 
                        "<span id='tags'><a href='tag.php?tag={$tag}'>" . $tagDetails[$i]['name'] . 
                        "</a></span>&nbsp;";
                    }
                    echo $output;
                 ?>
            </div>
            </p>
            <p class="meta">
                <a href="http://last.fm/tag/<?php echo $_GET['tag']; ?>" target="_blank">Visit more tags similar to <b><?php echo $_GET['tag']; ?></b> at Last.fm</a></p>
            <p>  <br />
                <h3>Top Artists</h3>
                <?php $topArtistByTag= $userSession->getTopArtistByTag($_GET['tag']);  ?>
                <div id="topArtistByTag">
                    <ul>
                        <?php if(!isset($topArtistByTag['error'])){ 
                            $result="";
                        for($i=0;$i<count($topArtistByTag);$i++){
                            $artistName=urlencode($topArtistByTag[$i]['name']);
                            $result=$result . 
                            "<li><a target='_blank' href='artist.php?name={$artistName}'>" .
                            "<img width='100px' height='100px' src='{$topArtistByTag[$i]['image'][2]['#text']}' /><br />" .
                            $topArtistByTag[$i]['name'] .
                            "</a></li>";
                            
                        }
                        echo $result;
                        ?>
                            <pre><?php //print_r($topArtistByTag); ?></pre> 
                        <?php }else{
                            echo $topAlbumByTag['error'];
                        } ?>
                    </ul>
                </div>
                
            </p>    
            <p>  <br />
             <div>&nbsp;<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>   
                <div id="topAlbumByTag">
                    <h3>Top Albums</h3>
                <?php $topAlbumByTag= $userSession->getTopAlbumByTag($_GET['tag']);  ?>
                    <ul>
                        <?php if(!isset($topAlbumByTag['error'])){ 
                            $result="";
                        for($i=0;$i<count($topAlbumByTag);$i++){
                            $albumName=urlencode($topAlbumByTag[$i]['name']);
                            $artistName=urlencode($topAlbumByTag[$i]['artist']['name']);
                            $result=$result . 
                            "<li><a target='_blank' href='album.php?name={$albumName}&artist={$artistName}'>" .
                            "<img width='100px' height='100px' src='{$topAlbumByTag[$i]['image'][2]['#text']}' /><br />" .
                            $topAlbumByTag[$i]['name'] .
                            "</a></li>";
                            
                        }
                        echo $result;
                        ?>
                            <pre><?php //print_r($topAlbumByTag); ?></pre> 
                        <?php }else{
                            echo $topAlbumByTag['error'];
                        } ?>
                    </ul>
                </div>
                
            </p>
        </div> 
<?php } ?>
</div>
