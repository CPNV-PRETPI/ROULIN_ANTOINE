<html>
<body>
<?php
echo "Hello World !";
?>
<a href="../index.php?action=displayLogin"><button>Login</button></a>
<?php if(isset($_SESSION['username'])):?>
    <p><?= $_SESSION['username'];?></p>
    <a href="../index.php?action=logout"><button>Logout</button></a>
<?php endif;?>
</body>
</html>

