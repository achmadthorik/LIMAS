<?php
session_start();
require_once './config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <!-- XAVIER Supports -->
    <script type="text/javascript">
        var key = "";
    </script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="./resources/css/bootstrap.min.css" />

    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="./resources/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="./resources/js/database.js"></script>
    <script type="text/javascript" src="./resources/js/bootstrap.min.js"></script>

    <!-- Check session -->
    <script type="text/javascript">

    </script>
  <style type="text/css">
  html,body{
    max-width : 100%;
    overflow-x: hidden;
  }
      .page-bg{
        background: url('./resources/images/buku1.jpg') no-repeat scroll;
        -webkit-filter: blur(3px);
        -moz-filter: blur(3px);
        -o-filter: blur(3px);
        -ms-filter: blur(3px);
        filter: blur(3px);
        position: absolute;
        width:100%;
        height:100%;
        top:0;
        left:0;
        z-index:-1;
}
      input{
        opacity : 0.7;
        color: #ffff;

}

  </style>
</head>
<body>

    <nav class="navbar navbar-default" style="background: transparent; border: 0;">
            <div>
               <div class="navbar-header"><a class="navbar-brand navbar-link" href="#"  style="color: white;">Perpustakaan PAPSI</a>
              </div>
              <div class="row">
                <div class="navbar-text col-lg-9">
                  <a href="login.php" class="navbar-link navbar-right" style="color :white;">Login
                   <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                </div>
              </div>
           </div>
    </nav>

    <div class="container-fluid">
    <!--    <div class="row">
            <div class="col-xs-2 col-xs-offset-10" style="margin-top: 3vh" align="center">
                <a class="btn btn-link" href="./login.php">
                Login</a>
            </div>
        </div>-->

        <div class="row" style="margin-top: 23vh">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-xs-12" align="center"><h1 style="font-size: 90px; color: white;">Search</h1></div>
                </div>
                <div class="input-grup">
                    <div class="col-xs-10 col-xs-offset-1" align="center">
                        <form action="result.php" method="GET" id="XXX">
                          <div class="input-group" style="width: 100%">
                             <input type="text" name="cari" class="form-control" required="Massukan Judul" style=" border-radius: 153px 153px 153px 153px; height: 45px; font-size: 20px;">
                             <div class="input-group-btn" style="margin: 5px -99px;float: left;z-index: 1000000;">
                                <button class="btn btn-primary glyphicon glyphicon-pencil" style="border-radius: 0px 162px 162px 0px; height:45px; margin-top:-6px;width:100px" data-toggle="tooltip" data-placement="bottom" title="Temukan Bukumu"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="page-bg">
</div>
</body>
</html>
