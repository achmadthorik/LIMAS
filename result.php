<?php
session_start();
require_once './config.php';
$dir    = './language/' . $lang. '/result.json';
$file   = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
      result
  </title>

    <!-- XAVIER Supports -->
    <script type="text/javascript">

    </script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="./resources/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./resources/css/bootstrap-select.min.css" />
    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="./resources/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="./resources/js/database.js"></script>
    <script type="text/javascript" src="./resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./resources/js/bootstrap-select.min.js"></script>

    <!-- Check session -->
    <script type="text/javascript">

    </script>
    	<style>
      #flipkart-navbar {
    background-color: #2874f0;
    color: #FFFFFF;
}

.row1{
    padding-top: 10px;
}

.row2 {
    padding-bottom: 20px;
}

.flipkart-navbar-input {
    padding: 11px 16px;
    border-radius: 2px 0 0 2px;
    border: 0 none;
    outline: 0 none;
    font-size: 15px;
    color: black;
    border-radius: 153px 0px 4px 153px;
}

.flipkart-navbar-button {
    background-color: #ffe11b;
    border: 1px solid #ffe11b;
    border-radius: 0 2px 2px 0;
    color: #565656;
    padding: 13px 0;
    height: 43px;
    cursor: pointer;
    border-radius: 0px 153px 153px 0px;
}

.cart-button {
    background-color: #2469d9;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .23), inset 1px 1px 0 0 hsla(0, 0%, 100%, .2);
    padding: 10px 0;
    text-align: center;
    height: 41px;
    border-radius: 2px;
    font-weight: 500;
    width: 120px;
    display: inline-block;
    color: #FFFFFF;
    text-decoration: none;
    color: inherit;
    border: none;
    outline: none;
}

.cart-button:hover{
    text-decoration: none;
    color: #fff;
    cursor: pointer;
}

.cart-svg {
    display: inline-block;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    margin-right: 8px;
}




.dropdown {
    position: relative;
    display: inline-block;
    margin-bottom: 0px;
}


.links {
    color: #fff;
    text-decoration: none;
}

.links:hover {
    color: #fff;
    text-decoration: none;
}

.profile-links {
    font-size: 12px;
    font-family: 'Roboto', sans-serif;
    border-bottom: 1px solid #e9e9e9;
    box-sizing: border-box;
    display: block;
    padding: 0 11px;
    line-height: 23px;
}

.profile-li{
    padding-top: 2px;
}

.largenav {
    display: none;
}

.smallnav{
    display: block;
}

.smallsearch{
    margin-left: 15px;
    margin-top: 15px;
}

.menu{
    cursor: pointer;
}

@media screen and (min-width: 768px) {
    .largenav {
        display: block;
    }
    .smallnav{
        display: none;
    }
    .smallsearch{
        margin: 0px;
    }
}

/*Sidenav*/


.sidenav-heading{
    font-size: 36px;
    color: #fff;
}

/*untuk blur*/


    	</style>
</head>
<body>




<div id="flipkart-navbar" class="navbar-fixed-top">
    <div class="container">
        <div class="row row1">
            <ul class="largenav pull-right">


            </ul>
        </div>
        <div class="row row2">
            <div class="col-sm-2">
                <h2 style="margin:0px;"><span class="smallnav menu" onclick="openNav()">Find</span></h2>
                <h1 style="margin:0px;"><span class="largenav"><?=$arr['cari']?></span></h1>
            </div>
            <div class="flipkart-navbar-search smallsearch col-sm-8 col-xs-11">
                <div class="row">

                  <form role="search" action="" method="GET" id="XXX">
                    <input class="flipkart-navbar-input col-xs-11 cari" type="text" placeholder="<?=$arr['search']?>" value="<?php echo @$_GET["cari"];?>">
                    <button class="flipkart-navbar-button col-xs-1" id="btnsearch" onclick="">
                        <svg width="15px" height="15px">
                            <path d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868
                            11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0
                            2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895
                            6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 "></path>
                        </svg>
                    </button>
                  </form>




                </div>
            </div>
            <div class="cart largenav col-sm-2">
                <a class="cart-button" href="login.php">
                   <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                     Login
                </a>
            </div>
        </div>
    </div>
</div>




<div class="container content">
    <div class="col-lg-12">
        <div class="col-lg-11 col-lg-offset-1">
            <table style="align: center; margin-top: 78px; margin-left: 62px;">
                <tbody id="datatable"></tbody>

            </table>
            <div>
                <nav aria-label="Page navigation" style="margin: -12px 10px 0 10px;">
                    <ul class="pager">
                        <li class="previous" id="previous">
                            <a id="aprevious" onclick="PopulateTable('','previous');">
                                <span aria-hidden="true">&larr;</span>
                                Previous
                            </a>
                        </li>
                        <li><label style="margin:6px" id="page">PAGE<label></li>
                        <li class="next" id="next">
                            <a id="anext" onclick="PopulateTable('','next');">
                                Next
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
    </div>
</div>

<!--Modal view-->
<!--
<div id="ModalView" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalResult" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">

            <h4 class="modal-title" id="ModalResult"><?=$arr['judulmodal']?>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <table class="table">
                    <thead>
                        <?php
                        foreach ($arr['table2'] as $key => $value) {
                            if ($key === 'action') {
                                echo "<tr style=\"max-width:30px\">{$value}</th>";
                                break;
                            }
                            echo "<th>{$value}</th>";
                        }
                        ?>
                    <tbody id="datatablee"></tbody>
                </table>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
                        <?=$arr['kembali']?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>-->

<script type="text/javascript">
PopulateTable();
<?php if(isset($_GET['cari'])){echo "PopulateTable('{$_GET['cari']}');";}?>
$(".cari").keyup(function(e){
  if (e.which == 13) {
    PopulateTable($(".cari").val());
  }
});
$("#btnsearch").click(function(e){PopulateTable($(".cari").val());
});
$("#XXX").submit(function(e){e.preventDefault();});
var currentpage = 0;
var totalpages = 0;



function PopulateTable(id, mode, pagez) {
  if (!pagez) {
      pagez = 0;
  }
  if (!id) {
      id = "";
  }
  if (mode) {
      if (mode == "next") {
          if (currentpage != totalpages - 1) {
              pagez = currentpage += 1;
          } else {
              return;
          }
      } else if (mode == "previous") {
          if (currentpage != 0) {
              pagez = currentpage -= 1;
          } else {
              return;
          }
      }
  }
    var key = "";
    var query = {"action" : "populatetable_result", "search" : id, "key" : key, "page" : pagez};
        XAVIER({"processor" : "./processor/result", "data" : query}, function(data) {
            var items = [];
            if (data === "noresult") {
                items.push("<font style='margin-top: 20px;'>No result</font>");
            } else {
                if(data) {
                    var butcher = JSON.parse(data);
                    var pages   = butcher["pages"];
                    var xjson = $.parseJSON(butcher["data"]);
                }
                $.each(xjson, function(index, value) {
                    items.push("<tr><td>&nbsp</td></tr><tr>" +
                    "<td style='font-size: 22px; color: #000099' colspan='2'>" +
                     value[0] + "</td></tr>");

                    items.push("<tr><td width='50px'><b>Tersedia</b></td> <td>" +  value[1] +"</td></tr>");
                    items.push("<tr><td width='50px'><b>Jenis</b></td> <td>" +  value[2] +"</td></tr>");
                    items.push("<tr><td width='90px'><b> Deskripsi </b></td> <td>" +  value[3] +"</td></tr>");
              /*      items.push("<td width='50px'>" + "<a href='#Ubah' onclick=\"view('" + value[0] + //lihat
                    "')\"><?=$arr['table']['detail']?></a>" + "</td></tr><tr><td>&nbsp</td></tr>"
                  );*/

                });
                totalpages = pages;
                if (pages == 1) {
                    $("#previous").attr("class", "previous disabled");
                    $("#next").attr("class", "next disabled");
                } else if (currentpage == 0) {
                    $("#next").attr("class", "next");
                    $("#previous").attr("class", "previous disabled");
                } else if (currentpage == pages - 1) {
                    $("#previous").attr("class", "previous");
                    $("#next").attr("class", "next disabled");
                } else {
                    $("#previous").attr("class", "previous");
                    $("#next").attr("class", "next");
                }
            }
            var output = items.join("");
            $("#datatable").html(output);
            $("html, body").animate({ scrollTop: 0 }, "fast");
            var xaxa = currentpage + 1;
            if (pages !== 0) {
                $("#page").html("Halaman " + xaxa + " dari " + pages + " halaman");
            } else {
                $("#page").html("Tidak ada hasil");
                currentpage = 0;
                $("#previous").attr("class", "previous disabled");
                $("#next").attr("class", "next disabled");
            }
        });
    }
function set(puzzle) {
    totalpages = puzzle;
    return puzzle;
}





</script>

</body>
</html>
