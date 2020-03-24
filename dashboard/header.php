<?php
session_start();
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__)));
}
require_once __ROOT__ . '/config.php';
require_once __ROOT__ . '/configuration/permission.php';
require_once './../configuration/dashboard.php';
define('URI', isset($_SERVER['HTTPS']) ? 'https' : 'http' . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
if (!isset($_SESSION[APPNAME]['name'], $_SESSION[APPNAME]['userid'], $_SESSION[APPNAME]['level'])) {
    unset($_SESSION[APPNAME]);
    header('Location: ./../login.php?page=' . basename($_SERVER['PHP_SELF']));
    //echo '<html><body><form action="./../login.php" method="post" id="destination"><input type="hidden" name="page" value="' . basename($_SERVER['PHP_SELF']) . '"></form><script>document.getElementById("destination").submit();</script></body></html>';
}
function activeheader($file = '')
{
    if ('./' . basename($_SERVER['PHP_SELF']) === $file) {
        echo 'active';
    }
}
//echo session_id();
//echo explode("_", $lang)[0];
//echo basename($_SERVER['PHP_SELF']);
//echo basename(MENU['transactions'][1]);
?>
<!DOCTYPE html>
<html lang="<?=explode('_', $lang)[0];?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php
    foreach (MENU as $key => $value) {
        if ('./' . basename($_SERVER['PHP_SELF']) === $value[1] || basename($_SERVER['PHP_SELF']) === "index.php") {
            echo $value[0];
            break;
        }
    }
    ?></title>

    <!-- XAVIER Supports -->
    <script type="text/javascript">
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style');
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            );
            document.querySelector('head').appendChild(msViewportStyle)
        }
        var key = "<?php echo substr(
            password_hash(
                substr(session_id(), 2, 8). $_SESSION[APPNAME]['userid'] .substr(session_id(), 4, 17),
                PASSWORD_DEFAULT
            ),
            7
        ); ?>";
    </script>

    <style>
    @-webkit-viewport   { width: device-width; }
    @-moz-viewport      { width: device-width; }
    @-ms-viewport       { width: device-width; }
    @-o-viewport        { width: device-width; }
    @viewport           { width: device-width; }

    .noselect {
      -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
         -khtml-user-select: none; /* Konqueror HTML */
           -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently
                                      supported by Chrome and Opera */
    }
    html body {
      -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
         -khtml-user-select: none; /* Konqueror HTML */
           -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently
                                      supported by Chrome and Opera */
    }
    input[type="text"]:disabled {
        cursor: default;
    }
    li.disabled a {
        cursor: default !important;
    }
    li a {
        cursor: pointer;
    }
    </style>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="./../resources/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./../resources/css/bootstrap-select.min.css" />

    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="./../resources/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="./../resources/js/database.js"></script>
    <script type="text/javascript" src="./../resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./../resources/js/bootstrap-select.min.js"></script>

</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-sm hidden-md" href="#"><?=TITLE?></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $level = $_SESSION[APPNAME]['level'];
                    $permission = array();
                    foreach (array_reverse(PERMISSIONS) as $key1 => $value1) {
                        if ($level === $key1) {
                            foreach ($value1 as $key2 => $value2) {
                                if ($key2 === 'inheritance') {
                                    $level = $value2;
                                } elseif ($key2 === 'permissions') {
                                    foreach ($value2 as $key3 => $value3) {
                                        array_push($permission, $value3);
                                    }
                                }
                            }
                        }
                    }
                    $i = 0;
                    foreach (MENU as $key1 => $value1) {
                        foreach ($permission as $key2 => $value2) {
                            if ($key1 === $value2) {
                                echo '<li class="menu ';
                                if ($value1[1] === './') {
                                    activeheader($value1[1]);
                                    activeheader($value1[1] . 'index.php');
                                } else {
                                    activeheader($value1[1]);
                                }
                                $class = 'menu';
                                if ($value1[1] === './about.php') {
                                    $class = 'menu hidden-sm';
                                }
                                echo ("
                                    \">
                                    <a href={$value1[1]} class=\"{$class}\">
                                    <span class=\"{$value1[2]}\"></span>&nbsp;{$value1[0]}</a></li>"
                                );
                            }
                        }
                        $i++;
                    }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION[APPNAME]["name"]; ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            foreach (USER as $key => $value) {
                                if ($key === 'logout') {
                                    //echo '<li role="separator" class=divider></li>';
                                }
                                echo ("
                                    <li>
                                        <a href=\"{$value[1]}\">{$value[0]}</a>
                                    </li>
                                ");
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
