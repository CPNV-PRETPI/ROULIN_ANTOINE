<html>
<body>
<?php
echo "Hello World !";
?>
<a href="../index.php?action=displayRegister"><button>S'inscrire</button></a>
<?php if(isset($_SESSION['userUsername'])):?>
    <p><?= $_SESSION['userUsername'];?></p>
<?php endif;?>
</body>
</html>

