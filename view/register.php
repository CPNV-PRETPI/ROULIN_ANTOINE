<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BudgetPlanner - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center text-dark mt-5">Register</h1>
            <div class="card my-5">
                <?php if(isset($error)):?>
                    <div class="alert alert-warning m-1" role="alert">
                        <?= $error;?>
                    </div>
                <?php endif;?>
                <form class="card-body cardbody-color p-lg-5" method="post" action="../index.php?action=register">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="userEmail" placeholder="Type your email here" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="userUsername" placeholder="Type your username here" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="userPassword" placeholder="Type your password here" required>
                    </div>
                    <div class="mb-3">
                        <label for="userPasswordVerify" class="form-label">Password Verify</label>
                        <input type="password" class="form-control" id="userPasswordVerify" name="userPasswordVerify" placeholder="Type your password again here" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 mb-1 w-100">Register</button>
                    </div>
                    <div class="text-center">
                        <a href="../index.php"><button type="button" class="btn btn-danger px-5 mb-5 w-100">Cancel</button></a>
                    </div>
                    <div id="emailHelp" class="form-text text-center mb-5 text-dark">
                        Already Registered ?
                        <a href="../index.php?action=login" class="text-dark fw-bold">Login to your Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>