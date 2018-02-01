<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Chat </title>
    <!-- CORE CSS -->
    <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <!-- THEME CSS -->
    <link href="/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="container">
    <div><a href="/user/logout">Déconnexion</a></div>

    <h4> Utilisateurs connectés</h4>
    <?php
    if (isset($connectedUsers) && !empty($connectedUsers)) {
        foreach ($connectedUsers as $connectedUser) {
            echo $connectedUser."\n";
        }
    }
    ?>
    <h4>Discussion</h4>
    <div id="messages"></div>
    <h4>Envoyé votre message</h4>
    <form id="form-message" method="post" action="/">
        <input type="text" name="message" id="message" placeholder="Votre message" required="required">
        <input type="submit" value="Envoyer">
    </form>
</div>

</body>
<script type="text/javascript" src="/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/front.js"></script>
<script type="text/javascript" src="/js/chat.js"></script>
</html>