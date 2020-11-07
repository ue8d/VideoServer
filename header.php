<header>
<h1 class="header">
    <a class="header" href="/">ue8d's Videos</a>
</h1 class="header">
<nav class="pc-nav">
    <ul class="header">
        <li class="header"><a class="header" href="/about.php">ABOUT</a></li>
        <li class="header"><a class="header" href="/contact.php">CONTACT</a></li>
        <li class="header"><a class="header" href="/dbInsert.php">DBINSERT</a></li>
        <?php
        if($_SESSION["id"] != null) {
            echo '<li class="header"><a class="header" href="/logout.php">LOGOUT</a></li>';
        }else {
            echo '<li class="header"><a class="header" href="/login.php">LOGIN</a></li>';
        }
        ?>
    </ul>
</nav>
</header>