<?php
require_once "header.php";
$dir    = './../language/' . $lang. '/buku_lokasi.json';
$file   = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Dashboard</div> -->
                <div class="panel-body">
                       <ul class="nav nav-tabs">
                         <li id="x"><a data-toggle="tab" href="#menu1" id="buku"><?=$arr['buku']?></a></li>
                         <li><a data-toggle="tab" href="#menu2" id="lokasi"><?=$arr['lokasi']?></a></li>
                       </ul>
                       <div class="tab-content">
                         <div id="menu1" class="tab-pane fade">
                           <div id="tampung1"></div>
                         </div>
                         <div id="menu2" class="tab-pane fade">
                           <div id="tampung2"></div>
                         </div>
                       </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

  $("#x").attr("class", "active");
  $("#buku").attr("aria-expanded", true);
  $("#menu1").attr("class", "tab-pane fade active in");
  $("#tampung1").load("buku.php");
});
//$(document).ready(
//    function(){
        $("#lokasi").click(function(){
            $("#tampung1").html("");
            $("#tampung2").load("locations.php");
        });
//    }
//);

//$(document).ready(
//    function(){
        $("#buku").click(function(){
            $("#tampung2").html("");
            $("#tampung1").load("buku.php");
        });
//    }
//);

</script>
