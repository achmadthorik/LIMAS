<?php
session_start();
require "./config.php";

$dir = './language/' . $lang . '/login.json';
$file = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);

//unset($_SESSION[APPNAME]);
if (isset($_SESSION[APPNAME]['name'], $_SESSION[APPNAME]['userid'], $_SESSION[APPNAME]['level'])) {
    header('Location: ./dashboard');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Login</title>

    <script type="text/javascript">
        var key  = "<?php
        echo substr(
            password_hash(
                substr(session_id(), 4, 13).'ru048a6rf86'.substr(session_id(), 2, 20),
                PASSWORD_DEFAULT
            ),
            7
        );
        ?>";
        var page = "<?php
        if (isset($_GET['page'])) {
            echo "./dashboard/{$_GET['page']}";
            $arr['home'] = "Anda harus login dahulu sebelum melanjutkan";
        } else {
            echo "./dashboard/";
        }
        ?>";
    </script>
    <style>
        .loading {
            background: url('./resources/images/loading.png');
            background-image: url('./resources/images/loading.svg'), none;
        }
        .containers {
            -webkit-filter: blur(1px);
               -moz-filter: blur(1px);
                -ms-filter: blur(1px);
                 -o-filter: blur(1px);
                    filter: blur(1px);
}
    </style>
    <!--style="margin-top: 13%;margin-bottom: 13%"-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="./resources/css/bootstrap.min.css" />

    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="./resources/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="./resources/js/database.js"></script>
    <script type="text/javascript" src="./resources/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container" style="height: 100%">
        <div class="row" style="margin-top: 13%;margin-bottom: 13%">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=$arr['title']?></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="formlogin">
                            <div class="form-group hidden" id="incorrect">
                                <div class="col-md-10 col-md-offset-1" align="center">
                                    <div class="alert alert-danger" role="alert" id="loginMessage">
                                        Username or password is incorrect
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="default">
                                <div class="col-md-12" align="center">
                                    <h4><a class="btn-link" href="./">
                                        <?=$arr['home']?>
                                    </a></h4>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="userid" class="col-md-4 control-label"><?=$arr['userid']?></label>

                                <div class="col-md-6">
                                    <input id="userid" type="text" class="form-control" value="" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label"><?=$arr['password']?></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"><?=$arr['remember']?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary btn-block" id="loginsubmit"
                                    data-loading-text="Logging in..." autocomplete="off">
                                        <?=$arr['btnlogin']?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
history.pushState(null, null, '<?=$_SERVER['PHP_SELF']?>');
$("#formlogin").submit(function(e) {
    e.preventDefault();
    var $btn = $("#loginsubmit").button('loading');
    $btn.focus();
    var $form = $(this),
        userid   = $form.find("input[id='userid']"),
        password = $form.find("input[id='password']");
    userid.attr("readOnly", true);
    password.attr("readOnly", true);
    var query = {"userid" : userid.val(), "password" : password.val(), "key" : key};
    XAVIER({"processor" : "./processor/login", "data" : query}, function(data) {
        if(data === "MATCH") {
            $(location).attr("href", page);
        } else if(data === "ERROR") {
            alert("SERVER ERROR, TRY AGAIN LATER");
            $btn.button('reset');
            userid.attr("readOnly", false);
            password.attr("readOnly", false);
        } else if(data === "MISMATCH"){
            $("#default").attr("class", "form-group hidden");
            $("#incorrect").attr("class", "form-group");
            $btn.button('reset');
            userid.attr("readOnly", false);
            password.attr("readOnly", false);
        }
    }, function(xhr, ajaxOptions, thrownError) {
        if(xhr.readyState == 4) {
            if(xhr.status==404) {
                alert("DATA CORRUPTION, PLEASE RELOAD PAGE");
            } else if(ajaxOptions === "error") {
                alert("SOMETHING WENT WRONG, TRY AGAIN IN THE LITTLE BIT");
            }
        } else if (xhr.readyState == 0) {
            alert("No connection");
        }
    });
});
</script>
</body>
</html>
