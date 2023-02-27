<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<?php if(isset($error)):?>
    <p><?= $error;?></p>
<?php endif;?>
<div class="container shadow p-3 mb-5 bg-white rounded">
        <h1 class="my-5"><b>Sign in</b></h1>
        <form method="POST" action="../index.php?action=register">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="userEmail" placeholder="Type your email here" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="userUsername" placeholder="Type your username here">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="userPassword" placeholder="Type your password here">
            </div>
            <div class="mb-3">
                <label for="passwordVerify" class="form-label">Password verify</label>
                <input type="password" class="form-control" id="passwordVerify" name="userPasswordVerify" placeholder="Type your password again here">
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
            <a href="../index.php?action=home"><button type="button" class="btn btn-danger">Cancel</button></a>
        </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>