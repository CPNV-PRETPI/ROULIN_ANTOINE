<html>
<body>
<?php
echo "Hello World !";
?>
<a href="../index.php?action=displayLogin"><button>Login</button></a>
<?php if(isset($_SESSION['userUsername'])):?>
    <p><?= $_SESSION['userUsername'];?></p>
<?php endif;?>
</body>
</html>

