<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Authentification </title>
</head>
<body>

<div class="container">
    <?php if (isset($errors) && !empty($errors)) {
        foreach ($errors as $error) {
            echo $error."\n";
        }
    } ?>
    <form class="form-signin" action="/user/login" method="post">
        <h2 class="form-signin-heading">Authentification</h2>
        <input type="text" name="username" id="username" class="form-control" placeholder="Nom d'utilisateur" required
               autofocus>
        <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Mot de passe"
               required>
        <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
        <div><a href="/user/register">Créer un compte</a></div>
    </form>

</div>

</body>
<? include './footer.view.php'; ?>
</html>