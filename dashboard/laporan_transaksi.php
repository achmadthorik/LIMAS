<?php
require './../config.php';
$dir    = './../language/' . $lang. '/laporan_transaksi.json';
$file   = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);
?>

<style type="text/css">#search{max-width: 220px;float: right;}</style>

            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px; margin-right: 2vh;">
                      <p data-controls-modal="#ModalDetail" data-backdrop="static"
                      data-keyboard="false" data-toggle="modal" title="Detail">
                            <?=$arr['judul']?>&nbsp;&nbsp;
                      </p>
                    </h4>
                    <div class="input-group">
                      <div class="btn-group" role="group">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                              <span id="filter">Filter</span>
                              <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                               <li><a href="#x" id="semua" onclick="filter('semua');"><?=$arr['filter']['semua']?></a></li>
                               <li><a href="#pinjam" id="masihpinjam" onclick="filter('pinjam');"><?=$arr['filter']['Peminjaman']?></a></li>
                               <li><a href="#kembali" id="sudah" onclick="filter('kembali');"><?=$arr['filter']['Pengembalian']?></a></li>
                          </ul>
                      </div>
                      <input  id="search" type="text" class="form-control" placeholder="<?=$arr['placeholderr']?>">
                      <div class="input-group-btn">
                          <button class="btn btn-default" id="btnSearch">
                              <i class="glyphicon glyphicon-search btnSearch" id="btnSearch"></i>
                          </button>
                      </div>
                  </div>
                </div>
                <table class="table">
                  <thead>
                    <?php
                    foreach ($arr['table'] as $key => $value) {
                        if ($key === 'action') {
                              echo "<th style=\"max-width:30px\">{$value}</th>";
                              break;
                        }
                          echo "<th>{$value}</th>";
                    }
                    ?>
                  </thead>
                    <tbody id="datatables"></tbody>
                </table>
                <div class="panel-footer text-center" style="padding: 0 !important; height: 50px !important">
                  <nav aria-label="Page navigation" style="margin: -12px 10px 0 10px">
                    <ul class="pager">
                      <li class="previous disabled" id="previous">
                            <a href="#" id="aprevious" onclick="PopulateTable('','previous');">
                                <span aria-hidden="true">&larr;</span>
                                    Previous
                            </a>
                        </li>
                        <li><label style="margin:6px" id="page">TEST TEST AAA TEST<label></li>
                        <li class="next" id="next">
                            <a href="#" id="anext" onclick="PopulateTable('','next');">
                                <span aria-hidden="true">&rarr;</span>
                                    Next
                            </a>
                        </li>
                      </ul>
                  </nav>
                </div>
            </div>

<div id="ModalDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?=$arr['judulmodal']?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <table class="table">
                        <thead>
                            <?php
                            foreach ($arr['table2'] as $key => $value) {
                                if ($key === 'action') {
                                    echo "<th style=\"max-width:30px\">{$value}</th>";
                                    break;
                                }
                                echo "<th>{$value}</th>";
                            }
                            ?>

                        </thead>
                        <tbody id="datatablees"></tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                            <?=$arr['kembali']?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var filterz = "semua";
PopulateTable();
$(document).ready(function() {
    var x = {"a" : "AAA"};
    PopulateTable();
})

function aaa() {
    $('input[type=checked]').each(function() {
        if (this.checked) {
            console.log($(this).val());
        }
    });
}
/**cari**/
$("#btnSearch").click(function(){
    $("#aprevious").attr("onclick", "PopulateTable('" + $(this).val() + "','previous');");
    $("#anext").attr("onclick", "PopulateTable('" + $(this).val() + "','next');");
    PopulateTable($("#search").val());
});

$("#search").keypress(function(event) {
    if (event.which == 13) {
        $("#aprevious").attr("onclick", "PopulateTable('" + $(this).val() + "','previous');");
        $("#anext").attr("onclick", "PopulateTable('" + $(this).val() + "','next');");
        PopulateTable($(this).val());
    }
});
/************************************************/
function filter(mode) {
    switch(mode) {
        case "semua":
            PopulateTable("", 0, "");
            filterz = "";
            $("#filter").html("Filter");
            break;
        case "pinjam":
            PopulateTable("", 0, "pinjam");
            filterz = "pinjam";
            $("#filter").html("Peminjaman");
            break;
        case "kembali":
            PopulateTable("", 0, "kembali");
            filterz = "kembali";
            $("#filter").html("Pengembalian");
            break;
        default:
            break;
    }
}
var currentpage = 0;
var totalpages = 0;

function PopulateTable(id, mode,option) {
  if (!id) {
      id = "";
  }
  if (!option) {
    option ='';
  }
  var pagez = 0;
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
      var query = {"action" : "populatetable", "search" : id, "key" : key, "page" : pagez, "option" : option};
      XAVIER({"processor" : "./../processor/laporan_transaksi", "data" : query}, function(data, status) {
        var items = [];
        if (data) {
            var butcher = $.parseJSON(data);
            var pages = butcher['pages'];
            var xjson = $.parseJSON(butcher['data']);
        }
    $.each(xjson, function(index, value) {
        items.push("<tr>");
        items.push("<td>" + value[0] + "</td>");
        items.push("<td>" + value[1] + "</td>");
        items.push("<td>" + value[2] + "</td>");
        items.push(
          "<td>" +
          "<a href='#Ubah' onclick=\"view('" + value[0] +
          "')\"><?=$arr['detail']?></a>" +
          "</td>"
        );
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
      var output = items.join("");
      $("#datatables").html(output);
      $("html, body").animate({ scrollTop: 0 }, "fast");
      var xaxa = currentpage + 1;
      $("#page").html("Halaman " + xaxa + " dari " + pages + " halaman");
  });
}
function view(id) {
    if (id) {
        $("#ModalDetail").modal("show");
        str = "<?=$arr['judulmodal']?>";
        str = str.replace(/\{(.*?)\}/g, name);
        $("#myModalLabel").text(str);
    }
  var key = "";
  var query = {"action" :"populatetable2", "id" : id, "key" : key, "option" : filterz};
  XAVIER({"processor" : "./../processor/laporan_transaksi", "data" : query}, function(data, status) {
      var items = [];
      if (data) {
          var xjson = $.parseJSON(data);
      }
    $.each(xjson, function(index, value) {
        items.push("<tr>");
        items.push("<td>" + value[0]+ "</td>");
        items.push("<td>" + value[1] + "</td>");
        items.push("<td>" + value[2] + "</td>");
        items.push("<td>" + value[3] + "</td>");
        items.push("<td>Rp." + value[4] + ",- </td>");
        items.push("<tr>");
    });
      var output = items.join("");
      $("#datatablees").html(output);
      console.log(data);
    })
}
</script>
