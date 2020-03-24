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
                          <div>
                               <ul class="nav nav-tabs">
                                  <li id="x"><a data-toggle="tab" href="#menu1" id="laporan_anggota">Laporan Anggota</a></li>
                                   <li><a data-toggle="tab" href="#menu2" id="laporan_transaksi">Laporan Transaksi</a></li>
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
  $("#x").attr("class","active");
  $("#laporan_anggota").attr("aria-expanded", true);
  $("#menu1").attr("class", "tab-pane fade active in");
  $("#tampung1").load("laporan_anggota.php");
})
//$(document).ready(
//    function(){
        $("#laporan_anggota").click(function(){
            $("#tampung2").html("");
            $("#tampung1").load("laporan_anggota.php");
     });
//    }
//);

//$(document).ready(
  //  function(){
        $("#laporan_transaksi").click(function(){
            $("#tampung1").html("");
            $("#tampung2").load("laporan_transaksi.php");
        });
  //  }
//);
</script>
</body>
</html>
