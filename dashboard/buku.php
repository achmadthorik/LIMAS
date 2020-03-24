<?php
//require_once "header.php";
require './../config.php';
$dir    = './../language/' . $lang. '/buku.json';
$file   = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);
?>

<style type="text/css">#searchh{max-width:220px;float:right;}</style>
<!--<div class="container">
    <div class="row">
        <div class="col-md-12">-->
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top:7.5px;margin-right:2vh">
                        <a href="#add" data-target="#ModalAdd" data-toggle="modal" title="Add Buku">
                            <?=$arr['addbuku']?>&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </h4>
                    <div class="input-group">
                        <input id="searchh" type="text" class="form-control" placeholder="<?=$arr['search']?>">
                        <div class="input-group-btn">
                            <button class="btn btn-default" id="btnSearchh">
                                <i class="glyphicon glyphicon-search btnSearchh"></i>
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
                                  if ($key === 'action') {
                                    echo "<th style=\"max-width:30px\">{$value}</th>";
                                    break;
                                  }
                                  echo "<th>{$value}</th>";
                                }
                              ?>
                      </thead>
                      <tbody id="datatable">
                      </tbody>
                  </table>
                </div>
                  <!--pager-->
                  <div class="panel-footer text-center" style="padding: 0 !important; height: 50px !important">
                    <nav aria-label="Page navigation" style="margin: -12px 10px 0 10px">
                      <ul class="pager">
                        <li class="previous disabled" id="previous">
                              <a href="#" id="aprevious" onclick="PopulateTable('','previous');">
                                  <span aria-hidden="true">&larr;</span>
                                      Previous
                              </a>
                          </li>
                          <li><label style="margin:6px" id="page">PAGE<label></li>
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
          <!--</div>
      </div>
  </div>-->


  <!--<input type="button" value="TES" onclick="aaa();">-->
  <!--modal add-->
  <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">

              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h4 class="modal-title" id="AddLabel"><?=$arr['modaladd']['title']?></h4>
              </div>

              <div class="modal-body">
                  <form class="form-horizontal" id="formAddBook">
                      <div class="form-group">
                          <label class="col-md-3 control-label"><?=$arr['modaladd']['id']?></label>
                          <div class="col-md-7">
                              <input type="text" class="form-control"
                              name="id" required autofocus autocomplete="off" />
                              <span class="help-block hidden" id="cekid">
                                  <strong> ID SUDAH DIPAKAI</strong>
                              </span>
                              <!--<p class="help-block" id="cekid"></p>-->
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><?=$arr['modaladd']['titlee']?></label>
                          <div class="col-md-7">
                              <input type="text" class="form-control"
                              name="title" required autocomplete="off" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><?=$arr['modaladd']['description']?></label>
                          <div class="col-md-7">
                              <input type="text" class="form-control"
                              name="description" autocomplete="off" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><?=$arr['modaladd']['category']?></label>
                          <div class="col-md-7">
                              <input type="text" class="form-control"
                              name="category" autocomplete="off" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-3 control-label"><?=$arr['modaladd']['jumlah']?></label>
                          <div class="col-md-7">
                              <input type="text" class="form-control"
                              name="jumlah" required autocomplete="off" />
                          </div>
                      </div>
                      <!--Drop down-->
                        <div class="form-group">
                            <label for="sel1" class="col-md-3 control-label">Lokasi</label>
                            <div class="col-md-3">
                                <select class="form-control" id="lokasiadd">
                                </select>
                          </div>
                        </div>
                      <!---->
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-success">
                                <?=$arr['modaladd']['btnsubmit']?>
                          </button>

                          <button type="reset" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                                <?=$arr['modaladd']['btncancel']?>
                          </button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal edit-->
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Editmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="editmodal"><?=$arr['modaledit']['title']?></h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="formEditBuku">

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['titlee']?></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control"
                            name="titleedit" required autofocus autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['description']?></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control"
                            name="descriptionedit" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['category']?></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control"
                            name="categoryedit" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['jumlah']?></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control"
                            name="jumlahedit" required autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['location']?></label>
                        <div class="col-md-3">
                            <select class="form-control" id="lokasiedit"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="idedit" value="">
                        <button type="submit" class="btn btn-success"
                        id="editbutton" onclick="">
                            <?=$arr['modaledit']['btnsubmit']?>
                        </button>

                        <button type="reset" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                            <?=$arr['modaledit']['btncancel']?>
                        </button>
                    </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
<!--Modal Delete-->
    <div id="ModalDelete" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 class="modal-title" style="text-align:center" id="messageDeletee">
                        <span aria-hidden="true">&times;</span>
                    </h3>
                </div>

                <div class="modal-body" style="margin:0px;padding:10px;border-top:0px;text-align:center">
                    <button type="button" class="btn btn-danger" id="btnDelete" onclick="">
                        <?=$arr['modaldelete']['btndelete']?>
                    </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="">
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

      $("#btnSearchh").click(function() {
          $("#aprevious").attr("onclick", "PopulateTable('" + $(this).val() +"','previous');");
          $("#anext").attr("onclick", "PopulateTable('" + $(this).val() +"','next');");
          PopulateTable($("#searchh").val());
      });
      $("#searchh").keypress(function(event) {
          if (event.which == 13 && $(this).val()) {
              $("#aprevious").attr("onclick", "PopulateTable('" + $(this).val() +"','previous');");
              $("#anext").attr("onclick", "PopulateTable('" + $(this).val() +"','next');");
              PopulateTable($(this).val());
          }
      });

      $("#formAddBook input[name='id']").on('focusout',function() {
        var query = {"action" : "cek", "key" : key, "search" : $(this).val()};
        XAVIER({"processor" : "./../processor/buku", "data" : query}, function(data) {
          if (data) {
              $("#cekid").attr("class", "help-block");

          } else {
              $("#cekid").attr("class", "help-block hidden");
          }
          console.log(data);
          //alert(data);
        });
      });

      function dropdown() {
        XAVIER({"processor" : "./../processor/buku", "data" : {"action" : "pilihan"}}, function(data) {
            var $rexautiz = JSON.parse(data);
            var item = [];
            $.each($rexautiz, function(dex, valu) {
                item.push('<option value="' + valu[0] + '">' + valu[1] + '</option>');
            });
            var out = item.join("");
            $("#lokasiadd").html(out);
            $("#lokasiedit").html(out);
        });
      }

      $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
      });

      function aaa() {
          $('input[type=checkbox]').each(function () {
              if (this.checked) {
                  console.log($(this).val());
              }
          });
      }

      $("#formAddBook button[type='reset']").click(function() {
        $("#formAddBook input[type='text']").val("");
      })

      $("#datatable").on('change', '.cbSingle', function() {
          console.log("AAA");
          if (this.checked == false) {
              $("#cbCheckAll")[0].checked = false;
          }
          if ($('.cbSingle:checked').length == $('.cbSingle').length ) {
              $("#cbCheckAll")[0].checked = true;
          }
      });
      /*$(".carie").keyup(function(e){
        if (e.which == 13) {
            PopulateTable($(".carie").val());
        }
      });

      $("#btnSearchh").click(function(e){
          PopulateTable($(".carie").val());
      });*/

      function PopulateTable(id, modee, pagezz) {
        if (!pagezz) {
            pagezz = 0;
        }
        if (!id) {
            id = "";
        }
        if (modee) {
            if (modee == "next") {
                if (currentpage != totalpages - 1) {
                    pagezz = currentpage += 1;
                } else {
                    return;
                }
            } else if (modee == "previous") {
                if (currentpage != 0) {
                    pagezz = currentpage -= 1;
                } else {
                    return;
                }
            }
        }

        //console.log(modee);
        var key = "";
        $("#page").html("Sedang memuat");
        var query = {"action" : "populatetable", "search" : id, "key" : key, "page" : pagezz};
        XAVIER({"processor" : "./../processor/buku", "data" : query}, function(data, status) {
          var items = [];
          if (data) {
              var butcher = $.parseJSON(data);
              var pages = butcher['pages'];
              var xjson = $.parseJSON(butcher['data']);
          }
              $.each(xjson, function(index, value) {
                items.push("<tr>");
                items.push("<td><input type='checkbox' class='cbSingle' id='" +
                index + "' value='" + value[0] + "'></td>");
                items.push("<td>" + value[0] + "</td>");
                items.push("<td>" + value[1] + "</td>");
                items.push("<td>" + value[2] + "</td>");
                items.push("<td>" + value[3] + "</td>");
                items.push("<td>" + value[4] + "</td>");
                items.push("<td>" + value[5] + "</td>");
                items.push(
                    "<td>" +
                    "<a href='#Edit' onclick=\"EditBuku('" + value[0] +
                    "')\"><?=$arr['table']['edit']?></a>&nbsp;" +
                    "<a href='#Delete' onclick=\"DeleteBuku('" + value[0] +
                    "','" + value[1] + "')\"><?=$arr['table']['delete']?></a>"
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
              var output = items.join("");
              $("#datatable").html(output);
              $("html, body").animate({ scrollTop: 0 }, "fast");
              var xaxa = currentpage + 1;
              if (pages !== 0) {
                  $("#page").html("Halaman " + xaxa + " dari " + pages + " halaman ");
              } else {
                  $("#page").html("Tidak ada hasil");
                  currentpage = 0;
                  $("#previous").attr("class", "previous disabled");
                  $("#next").attr("class", "next disabled");
              }
              //$("#page").html("Halaman " + xaxa + " dari " + pages + " halaman");
              dropdown();
              console.log(data);
          });
      }

      /*function set(puzzle) {
          totalpages = puzzle;
          return puzzle;
      }*/

      function DeleteBuku(id, judul, mode) {
          if (mode && mode === "delete") {
              $("#btnDelete").attr("onclick", "");
              var query = {"action" : "singledelete", "identifier" : id};
              XAVIER({"processor" : "./../processor/buku", "data" : query}, function(data) {
                  if (data === 'success') {
                    $("#ModalDelete").modal("hide");
                    PopulateTable('','',currentpage);
                  } else {
                      alert("BUKU SEDANG DIPINJAM");
                  }
              });
          } else if (mode && mode === "multipledelete") {
              var ids = [];
              var query = {"action" : "multipledelete", "identifier" : ids[0]};
              XAVIER({"processor" : "./../processor/buku", "data" : query}, function(data) {
                  if (data === 'success') {
                      $("#ModalDelete").modal("hide");
                      PopulateTable();
                  } else {
                      alert("Buku Di Pinjam");
                  }
              });
          } else {
              $("#btnDelete").attr("onclick", "DeleteBuku('"+id+"','"+judul+"','delete')");
              str = "<?=$arr['modaldelete']['message']?>";
              if ((str.match(/\{(.*?)\}/g)) == "{title}") {
                  str = str.replace(/\{(.*?)\}/g, judul);
              }
              $("#messageDeletee").text(str);
              $("#ModalDelete").modal({
                backdrop: "static",
                keyboard: false
              });
          }
      }
      $("#formAddBook").submit(function(event) {
          event.preventDefault();
          var $form = $(this),
              id          = $form.find("input[name='id']").val(),
              title       = $form.find("input[name='title']").val(),
              description = $form.find("input[name='description']").val(),
              category    = $form.find("input[name='category']").val(),
              jumlah      = $form.find("input[name='jumlah']").val(),
              location    = $form.find("select[id='lokasiadd']").val();
          if (id || description || category) {
            var query = {"action" : "newbook", "key" : key, "id" : id, "title" : title, "description" : description,
            "category" : category, "jumlah" : jumlah, "location" : location};
            XAVIER({"processor" : "./../processor/buku", "data" : query}, function(data) {
              if (data === 'success') {
                $("#ModalAdd").modal("hide");
                $("#formAddBook input[type='text']").val("");
                PopulateTable();
                currentpage = 0;
              } else {
                  alert("ID buku ada yang sama, silahkan masukkan ID buku lain");
              };
              console.log(data);
            });
          } else if (!title || !jumlah || !location ) {
              alert("Fill the form");
          }
      })

      function EditBuku(id, title) {
          var query = {"action" : "fillmodaledit", "identifier" : id};
          XAVIER({"processor" : "./../processor/buku", "data" : query, "key" : key}, function(data) {
            if (data) {
                var xobjectt = JSON.parse(data);
                var $forms = $("#formEditBuku");
                $forms.find("input[name='idedit']").val(id),
                $forms.find("input[name='titleedit']").val(xobjectt[0]),
                $forms.find("input[name='descriptionedit']").val(xobjectt[1]),
                $forms.find("input[name='categoryedit']").val(xobjectt[2]),
                $forms.find("input[name='jumlahedit']").val(xobjectt[3]),
                $forms.find("select[id='lokasiedit']").val(xobjectt[4]);
                str = "<?=$arr['modaledit']['title']?>";
                if ((str.match(/\{(.*?)\}/g)) == "{title}") {
                    str = str.replace(/\{(.*?)\}/g, xobjectt[0]);
                }
            $("#editmodal").text(str);
            $('#ModalEdit').modal({
              backdrop: "static",
              keyboard: false
            });
            console.log(data);
            };
         });
      }
      $("#formEditBuku").submit(function(event) {
        event.preventDefault();
        var $form = $(this),
            id          = $form.find("input[name='idedit']").val(),
            title       = $form.find("input[name='titleedit']").val(),
            description = $form.find("input[name='descriptionedit']").val(),
            category    = $form.find("input[name='categoryedit']").val(),
            jumlah      = $form.find("input[name='jumlahedit']").val(),
            location    = $form.find("select[id='lokasiedit']").val();
            var query = {"action" : "savemodaledit", "id" : id, "title" : title, "description" : description,
              "category" : category, "jumlah" : jumlah, "location" : location};
            XAVIER({"processor" : "./../processor/buku", "data" : query, "key" : key}, function(data) {
              $("#editmodal").text(str);
              $('#ModalEdit').modal({
                backdrop: 'static',
                keyboard: false
              });
              PopulateTable('','',currentpage);
              $("#ModalEdit").modal("hide");
            });
      });

      function test() {
          $(function() {
              str = $("#messageDeletee").text();
              str = str.replace(/\{(.*?)\}/g, "Afif Faris");
              console.log(str);
              $("#messageDeletee").text(str);
          });
      }

  </script>
