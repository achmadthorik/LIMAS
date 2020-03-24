<?php

require './../config.php';
$dir    = './../language/' . $lang. '/locations.json';
$file   = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);

?>

<style type="text/css">#search{max-width: 220px;float: right;}</style>
<!--<div class="container">
    <div class="row">
        <div class="col-md-12">-->
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;margin-right: 2vh">
                        <a href="#tambah" data-target="#ModalAdds" data-toggle="modal" title="Add Location">
                            <?=$arr["addlocation"]?><span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </h4>
                    <div class="input-group">
                        <input id="search" type="text" class="form-control" placeholder="<?=$arr['search']?>">
                        <div class="input-group-btn">
                            <button class="btn btn-default" id="btnsearch">
                                <i class="glyphicon glyphicon-search" ></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                            <th style="width:20px !important"><input type="checkbox" id="cbCheckAll"></th>
                            <?php
                            foreach ($arr['table'] as $key => $value) {
                                if ($key === "action") {
                                    echo "<th style=\"max-width: 30px\">{$value}</th>";
                                    break;
                                }
                                echo "<th>{$value}</th>";
                            }
                            ?>
                    </thead>
                    <tbody id="datatablee"></tbody>
                </table>
              </div>
                <div class="panel-footer text-center" style="padding: 0 !important; height: 50px !important">
                  <nav aria-label="Page navigation" style="margin: -12px 10px 0 10px">
                    <ul class="pager">
                      <li class="previous disabled" id="previous">
                                <a href="#" id="aaprevious" onclick="PopulateTable('','previous');">
                                    <span aria-hidden="true">&larr;</span>
                                        Previous
                                </a>
                            </li>
                            <li><label style="margin:6px" id="page">TEST TEST AAA TEST<label></li>
                            <li class="next" id="next">
                                <a href="#" id="aanext" onclick="PopulateTable('','next');">
                                     <span aria-hidden="true">&rarr;</span>
                                        Next
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <!--</div>
      </div>
</div>-->



<!-- Modal Tambah-->
<div id="ModalAdds" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="addmodal"><?=$arr['modaladd']['title']?></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formAddLocations">
                    <div class="form-group" class="col-md-3 control-label">
                        <label for="namalokasi" class="col-md-3 control-label">
                            <?=$arr['modaladd']['namarak']?>
                        </label>
                        <div class="col-md-7">
                            <input type="text" id="add_namalokasi" class="form-control"
                            name="namalokasi" autofocus required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tempat" class="col-md-3 control-label">
                                  <?=$arr['modaladd']['bagianrak']?>
                        </label>
                        <div class="col-md-7">
                            <input type="text" id="add_tempat" class="form-control"
                            name="tempat" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit"
                        name="newlocationsubmit" id="addbutton" onclick="">
                            <?=$arr['modaladd']['btnsubmit']?>
                        </button>
                        <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
                            <?=$arr['modaladd']['btncancel']?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit-->
<div id="ModalEdits" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Editmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="editmodal"><?=$arr['modaledit']['title']?></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formEditLocation">

                    <div class="form-group">
                        <label for="tempat" class="col-md-3 control-label">
                              <?=$arr['modaledit']['namarak']?>
                        </label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="editnamalokasi"
                            autofocus autocomplete="off" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Rak" class="col-md-3 control-label">
                                <?=$arr['modaledit']['bagianrak']?>
                        </label>
                        <div class="col-md-7">
                            <input type="text" name="edittempat"
                            class="form-control" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="editid" value="">
                        <button class="btn btn-success" type="submit"
                        name="editlocationsubmit" id="editbutton" onclick="">
                            <?=$arr['modaledit']['btnsubmit']?>
                        </button>
                        <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
                            <?=$arr['modaledit']['btncancel']?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal hapus-->
<div class="modal fade" id="ModalDeletes">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="messageDelete" style="text-align:center;">
                    <?=$arr['modaldelete']['message']?>
                </h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#ab" class="btn btn-danger" id="tombolhapus" onclick="">
                    <?=$arr['modaldelete']['btndelete']?>
                </a>
                <button type="button" class="btn btn-success" data-dismiss="modal">
                    <?=$arr['modaldelete']['btncancel']?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    PopulateTable();
    var currentpage = 0;
    var totalpages = 0;
    $(document).ready(function() {
        var x = {"a" : "AAA"};
        PopulateTable();
    });

    $("#cbCheckAll").change(function() {
        var status = this.checked;
        $('.cbSingle').each(function() {
            this.checked = status;
        });
    });

    $("#btnsearch").click(function() {
      $("#aaprevious").attr("onclick", "PopulateTable('" + $(this).val() +"','previous');");
      $("#aanext").attr("onclick", "PopulateTable('" + $(this).val() +"','next');");
      PopulateTable($("#search").val());
    });

    $("#search").keypress(function(event) {
      if (event.which == 13 && $(this).val()) {
        $("#aaprevious").attr("onclick", "PopulateTable('" + $(this).val() +"','previous');");
        $("#aanext").attr("onclick", "PopulateTable('" + $(this).val() +"','next');");
        PopulateTable($("#search").val());
      }
    });

    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });

    function aaa() {
        $('input[type=checked]').each(function() {
        if (this.checked) {
            console.log($(this).val());
        }
        });
    }


    $("#formAddLocations button[type='reset']").click(function() {
      $("#formAddLocations input[type='text']").val("");
    })


    $("#datatablee").on('change', '.cbSingle', function() {
        console.log("AAA");
        if (this.checked == false) {
            $("#cbCheckAll")[0].checked = false;
        }
        if ($('.cbSingle:checked').length == $('.cbSingle').length) {
            $("#cbCheckAll")[0].checked = true;
        }
    });

    /*$(".cari").keyup(function(e){
        if (e.which == 13) {
            PopulateTable($(".cari").val());
        }
    });
    $("#btnsearch").click(function(e){
        PopulateTable($(".cari").val());
    });*/

    function PopulateTable(id, mode, pagez) {
      if (!id) {
          id = "";
      }
      if (!pagez) {
          pagez= 0 ;
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
        $("#page").html("Sedang memuat");
        var query = {"action" : "populatetable1", "search" : id, "key" : key, "page" : pagez};
        XAVIER({"processor" : "./../processor/locations", "data" : query}, function(data, status) {
        var items1 = [];
        if (data) {
            var butcher = $.parseJSON(data);
            var pages = butcher['pages'];
            var xjson = $.parseJSON(butcher['data']);
        }
        $.each(xjson, function(index, value) {
            items1.push("<tr>");
            items1.push("<td><input type='checkbox' class='cbSingle' id='" +
            index + "' value='" + value[0] + "'></td>");
            items1.push("<td>" + value[0] + "</td>");
            items1.push("<td>" + value[1] + "</td>");
            items1.push("<td>" + value[2] + "</td>");
            items1.push(
              "<td>" +
              "<a href='#ubah' onclick=\"EditLokasi('" + value[0] +
              "')\"><?=$arr['table']['edit']?></a>&nbsp" +
              "<a href='#del' onclick=\"confirmDelete('" + value[0] +
              "','" + value[1] +"')\"><?=$arr['table']['delete']?></a>" +
              "</td>"
            );
        });
        totalpages = pages;
        if (pages == 1) {
            $("#next").attr("class", "next disabled");
            $("#previous").attr("class", "previous disabled");
        } else if (currentpage == 0) {
            $("#next").attr("class", "next");
            $("#previous").attr("class", "previous disabled")
        } else if (currentpage == pages - 1) {
            $("#previous").attr("class", "previous");
            $("#next").attr("class", "next disabled");
        } else {
            $("#previous").attr("class", "previous");
            $("#next").attr("class", "next");
        }
        var output = items1.join("");
        $("#datatablee").html(output);
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
        console.log(data);
      });
    }

    /*function set(puzzle) {
      totalpages = puzzle;
      return puzzle;
    }*/

    function confirmDelete(id, kodelokasi, modee) {
        if (modee && modee === "delete") {
            $("#tombolhapus").attr("onclick", "");
            var query = {"action" : "singledelete", "identifier" : id};
            XAVIER({"processor" : "./../processor/locations", "data" : query}, function(data) {
                if (data === 'success') {
                    $("#ModalDeletes").modal("hide");
                    PopulateTable('','',currentpage);
                  } else {
                    alert("SYSTEM ERROR");
                  }
                });
        } else if (modee && modee == "multipledelete") {
            var ids = [];
            var query = {"action" : "multipledelete", "identifier" : ids[0]};
            XAVIER({"processor" : "./../processor/locations", "data" : query}, function(data) {
                if (data === 'success') {
                      $("#ModalDeletes").modal("hide");
                      PopulateTable();
                    } else {
                        alert("Lokasi Dipakai Buku");
                    }
              });
        } else {
            $("#tombolhapus").attr("onclick", "confirmDelete('" +id+"', '"+name+"','delete')");
            str = "<?=$arr['modaldelete']['message']?>";
            if ((str.match(/\{(.*?)\}/g)) == "{kodelokasi}") {
                str = str.replace(/\{(.*?)\}/g, id);
            }
            $("#messageDelete").text(str);
            $("#ModalDeletes").modal({
              backdrop: "static",
              keyboard: false
            });
            console.log(str);
        }
    }

    $("#formAddLocations").submit(function(event) {
        event.preventDefault();
        var $form = $(this),
        idlokasi          = $form.find("input[name='id']").val(),
        namalokasi        = $form.find("input[name='namalokasi']").val(),
        tempat            = $form.find("input[name='tempat']").val();
        var query = {"action" : "newlocation", "key" : key, "id" : idlokasi, "namalokasi" : namalokasi, "tempat" : tempat};
        XAVIER({"processor" : "./../processor/locations", "data" : query}, function(data) {
          $("#formAddLocations input[type='text']").val("");
            $("#ModalAdds").modal("hide");
            PopulateTable();
            currentpage = 0;
        });
    })

    function EditLokasi(id, kodelokasi) {
        var query = {"action" : "fillmodaledit", "identifier" : id};
        XAVIER({"processor" : "./../processor/locations", "data" : query, "key" : key}, function(data) {
            if (data) {
                var xobject = JSON.parse(data);
                var $form = $("#formEditLocation");
                $form.find("input[name='editid']").val(id);
                $form.find("input[name='editnamalokasi']").val(xobject[0]);
                //$form.find("input[name='edittempat']").val(xobject[1]);
                $form.find("input[name='edittempat']").val(xobject[1]);
                str = "<?=$arr['modaledit']['title']?>";
                if ((str.match(/\{(.*?)\}/g)) == "{kodelokasi}") {
                    str = str.replace(/\{(.*?)\}/g, id);
                }
                $("#editmodal").text(str);
                $('#ModalEdits').modal({
                  backdrop: 'static',
                  keyboard: false
                });
                console.log(data);
              };
          });
    }
        $("#formEditLocation").submit(function(event) {
        event.preventDefault();
        var $form = $(this),
            idlokasi        = $form.find("input[name='editid']").val();
            namalokasi      = $form.find("input[name='editnamalokasi']").val();
            tempat          = $form.find("input[name='edittempat']").val();
                var query = {"action" : "savemodaledit", "key" : key, "id" : idlokasi, "namalokasi" : namalokasi,
                "tempat" : tempat};
            XAVIER({"processor" : "./../processor/locations", "data" : query, "key" : key}, function(data) {
                PopulateTable('','',currentpage);
                $("#ModalEdits").modal("hide");

            });
      });

    function test() {

        $(function() {
        str = $("#messageDelete").text();
        str = str.replace(/\{(.*?)\}/g, "Afif Faris Hudaifi");
        console.log(str);
        $("#messageDelete").text(str);
        });
    }

</script>
