<ul>
                <li>
                    <h3>Username Search</h3><br />
                    <div id="search-user">
    <form action="user.php" method="get">
        <input type="text" name="name" id="name" value="Enter Username" onfocus="this.value='';" />&nbsp;<input type="submit" value="Search" />
        Please enter exact username.
    </form>
</div><br />
                </li>
                <li>
                    <h3>Artist Search</h3><br />
                    <div id="search-user">
    <form action="artist.php" method="get">
        <input type="text" name="name" id="name" value="Enter Artist Name" onfocus="this.value='';" />&nbsp;<input type="submit" value="Search" />
        Please enter exact Artist name.
    </form>
</div><br />
                </li>
                <li>
                    <h3>Tag Search</h3><br />
                    <div id="search-user">
    <form action="tag.php" method="get">
        <input type="text" name="tag" id="name" value="Enter Tag" onfocus="this.value='';" />&nbsp;<input type="submit" value="Search" />
        Please enter a Tag.
    </form>
</div><br />
                </li>
                <?php if(isset($_SESSION['key'])){ ?>
                <li>
                    <ul>
                        <li><h3><a href="user.php?name=<?php echo $_SESSION['name']; ?>">Your Profile</a>..</h3></li>
                    </ul>
                </li>
                <?php } ?>
                <?php $php_self=explode("/",$_SERVER['PHP_SELF']);
    if($php_self[count($php_self) - 1] == "user.php"){  ?>
                <li>
                    <h3>User Menu</h3>
                    <ul>
                        <?php $no_of_shouts=$userSession->getShoutNo($userInfo['username']); ?>
                        <pre><?php //print_r($no_of_frnds); ?></pre>
                        <li><a target="_blank" href="http://www.last.fm/user/<?php echo $userInfo['username']; ?>/shoutbox">Shouts</a> (<?php echo $no_of_shouts['total']; ?>)<span>Get the Shouts of <?php echo $userInfo['username']; ?></span></li>
                        <li><a target="_blank" href="http://www.last.fm/user/<?php echo $userInfo['username']; ?>/friends">Friends</a><span>Get the Friend list of <?php echo $userInfo['username']; ?></span></li>
                        <li><a target="_blank" href="http://www.last.fm/user/<?php echo $userInfo['username']; ?>/events">Events</a><span>Get the Events of <?php echo $userInfo['username']; ?></span> </li>
                        <li><a target="_blank" href="http://www.last.fm/user/<?php echo $userInfo['username']; ?>/neighbours">Neighbours</a><span>Neighbours of <?php echo $userInfo['username']; ?></span> </li>
                    </ul>
                </li>
                <?php } ?>
                
</ul>