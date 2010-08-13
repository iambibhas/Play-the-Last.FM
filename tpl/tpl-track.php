
<div class="post">
<?php $trackInfo = $userSession->getTrackInfo($_GET['name'],$_GET['artist']);
    if(isset($trackInfo['error'])){
        echo "<h1>Error No. " . $trackInfo['error'] . " : " . $trackInfo['message'] . "</h1>";
    }else{
?>
        <div class="entry">
            <p>
                <div id="profile-image"><img src="<?php echo $trackInfo['albumImage']; ?>" /></div>
                <div id="track-desc">
                    <h3><a href="<?php echo $trackInfo['url']; ?>"><?php echo $trackInfo['name']; ?></a></h3>
                    Duration <i><?php echo floor($trackInfo['duration']/60) . ":" . ($trackInfo['duration']%60); ?></i><br />
                    Album : <a href="album.php?name=<?php echo urlencode($trackInfo['albumName']); ?>&artist=<?php echo urlencode($_GET['artist']); ?>">
                    <?php echo $trackInfo['albumName']; ?></a> by  
                    <a href="artist.php?name=<?php echo urlencode($_GET['artist']); ?>"> <?php echo urldecode($_GET['artist']); ?></a>
                    <br />
                    <div id="left-cont" >
                        <h2><?php echo $trackInfo['scrobbles']; ?></h2>
                        Scrobbles
                    </div>
                    <div id="right-cont" >
                        <h2><?php echo $trackInfo['listeners']; ?></h2>
                        Listeners
                    </div>
                </div>
            </p>
            <p class="meta">&nbsp;
            </p>
            <p>
                <h2 align="center">Like the track? Buy it.</h2>
                <div id="tracklist"><br />
                <?php $trackBuyLink = $userSession->getTrackBuyLink($_GET['name'],$_GET['artist']);
                if(isset($trackBuyLink['error'])){
                    echo "<h1>Error No. " . $trackBuyLink['error'] . " : " . $trackBuyLink['message'] . "</h1>";
                }else{ 
                    $outputPhy = "";
                    for($i=0;$i<count($trackBuyLink['physicals']);$i++){
                        $outputPhy = $outputPhy . 
                        "<li><a target='_blank' href='{$trackBuyLink['physicals'][$i]['buyLink']}'>" . 
                        $trackBuyLink['physicals'][$i]['supplierName'] . "</a></li>";
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
                    for($i=0;$i<count($trackBuyLink['download']);$i++){
                        $outputDow = $outputDow . 
                        "<li><a target='_blank' href='{$trackBuyLink['download'][$i]['buyLink']}'>" . 
                        $trackBuyLink['download'][$i]['supplierName'] . 
                        "</a> for {$trackBuyLink['download'][$i]['price']['currency']} 
                        {$trackBuyLink['download'][$i]['price']['amount']}
                        </li>";
                    }  ?>
                        <ul>
                    <?php
                    echo $outputDow;
                    ?> 
                        </ul>
                <pre><?php //print_r($trackBuyLink); ?> </pre>
                <?php } ?>   
                </div>                    
            </p>
        </div> 
<?php } ?>
</div>
