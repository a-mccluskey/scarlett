<?php
if($isMobile) { 
    echo '<div id="nav_border" style="display:none;">'; }
    else {
    echo "<div id=\"nav_border\">\n"; } 
?><nav>
<a href="<?php echo $MAIN_DOMAIN?>index.php">Home</a><hr>
<a href="index.php">Admin</a><hr>
<a href="article_add.php">Add a new article</a><hr>
<a href="article_viewer.php">Manage and view articles</a><hr>
<a href="gallery.php">Gallery Manager</a><hr>
<a href="login.php?i=2">Logout</a>
</nav></div>