
<div class="post">
<?php $albumInfo = $userSession->getAlbumInfo($_GET['name'],$_GET['artist']);
    if(isset($albumInfo['error'])){
        echo "<h1>Error No. " . $albumInfo['error'] . " : " . $albumInfo['message'] . "</h1>";
    }else{ 
?>
        <div class="entry">
           <pre><?php  //print_r($albumInfo); ?> </pre>
            <p>
                <div id="album-image" ><img width="128px" height="128px" src="<?php echo $albumInfo['image'][2]['#text']; ?>" /></div>
                <div id="track-desc">
                    <h2><a href="<?php echo $albumInfo['url']; ?>"><?php echo $albumInfo['name']; ?></a></h2> 
                    <div>by <a href="artist.php?name=<?php echo urlencode($albumInfo['artist']); ?>"><?php echo $albumInfo['artist']; ?></a></div>
                    <div id="left-cont" >
                        <h2><?php echo $albumInfo['playcount']; ?></h2>
                        Plays
                    </div>
                    <div id="right-cont" >
                        <h2><?php echo $albumInfo['listeners']; ?></h2>
                        Listeners
                    </div>
                </div>
            </p>

            <p>
                <h2 align="center">Like <?php echo $albumInfo['name']; ?>? Buy it..</h2>
                <div id="tracklist"><br />
                <?php $albumBuyLink = $userSession->getAlbumBuyLink($_GET['name'],$_GET['artist']);
                if(isset($albumBuyLink['error'])){
                    echo "<h1>Error No. " . $albumBuyLink['error'] . " : " . $albumBuyLink['message'] . "</h1>";
                }else{ 
                    $outputPhy = "";
                    for($i=0;$i<count($albumBuyLink['physicals']);$i++){
                        $outputPhy = $outputPhy . 
                        "<li><a target='_blank' href='{$albumBuyLink['physicals'][$i]['buyLink']}'>" . 
                        $albumBuyLink['physicals'][$i]['supplierName'] . "</a></li>";
                    }
                    
                }  ?>
                        <h3>Discs</h3>
                         <ul>
                    <?php
                    echo $outputPhy;
                    ?> 
                        </ul>
                        <h3>Downloads</h3>
                        <?php
                        $outputDow = "";
                        if(is_array($albumBuyLink['download'])){
                    for($i=0;$i<count($albumBuyLink['download']);$i++){
                        $outputDow = $outputDow . 
                        "<li><a target='_blank' href='{$albumBuyLink['download'][$i]['buyLink']}'>" . 
                        $albumBuyLink['download'][$i]['supplierName'] . 
                        "</a>";
                        if(isset($albumBuyLink['download'][$i]['price'])){
                            $outputDow = $outputDow  . " for {$albumBuyLink['download'][$i]['price']['currency']} 
                            {$albumBuyLink['download'][$i]['price']['amount']}";
                        }
                        $outputDow = $outputDow . "</li>";
                    }
                        }else{
                            $outputDow="<li>No Download link found..</li>";
                        }  ?>
                        <ul>
                    <?php
                    echo $outputDow;
                    ?> 
                        </ul>
                        <h3>Top Tags</h3>
                        <?php
                        $outputTag = "";
                        $albumTag=$albumInfo['toptags']['tag'];
                        if(isset($albumTag[0])){
                            for($i=0;$i<count($albumTag);$i++){
                                $outputTag = $outputTag . 
                                "<span id='tags'><a href='tag.php?tag={$albumTag[$i]['name']}'>" . 
                                $albumTag[$i]['name'] . 
                                "</a></span>&nbsp;";
                            }
                        }else if(isset($albumTag['name'])){
                            $outputTag = "<span id='tags'><a href='tag.php?tag={$albumTag[$i]['name']}'>" . 
                                $albumTag['name'] . 
                                "</a></span>&nbsp;";
                        }else{
                            $outputTag = "No Tags Found..";
                        }  ?>
                        <ul>
                    <?php
                    echo $outputTag;
                    ?> 
                        </ul>
                        
                        <h3>Wiki</h3>
                        <div id="album-bio">
                            <pre width="80"><?php if(isset($albumInfo['wiki']['content'])){
                                echo $albumInfo['wiki']['content']; 
                            }else{
                                echo "No details found";
                            }?></pre>
                        </div>
                <pre><?php //print_r($albumBuyLink); ?> </pre>  
                </div>                    
            </p>
        </div> 
<?php } ?>
</div>
