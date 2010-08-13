<ul>
                <li>
                    <h3>User Search</h3><br />
                    <div id="search-user">
    <form action="user.php" method="get">
        <input type="text" name="name" id="name" value="Enter Username" onfocus="this.value='';" />&nbsp;<input type="submit" value="Search" />
    </form>
</div><br />
                </li>
                <?php $php_self=explode("/",$_SERVER['PHP_SELF']);
    if($php_self[count($php_self) - 1] == "user.php"){  ?>
                <li>
                    <h3>User Menu</h3>
                    <ul>
                        <?php $no_of_shouts=$userSession->getShoutNo($userInfo['username']); ?>
                        <pre><?php //print_r($no_of_frnds); ?></pre>
                        <li><a href="#">Shouts</a> (<?php echo $no_of_shouts['total']; ?>)<span>Get the Shouts of <?php echo $userInfo['username']; ?></span></li>
                        <li><a href="#">Friends</a><span>Get the Friend list of <?php echo $userInfo['username']; ?></span></li>
                        <li><a href="#">Urna Congue Rutrum</a> (28)<span>Lorem Ipsum Dolor Sit Amit</span> </li>
                        <li><a href="#">Vivamus Fermentum</a> (13)<span>Lorem Ipsum Dolor Sit Amit</span> </li>
                    </ul>
                </li>
                <?php } ?>
                
            </ul>