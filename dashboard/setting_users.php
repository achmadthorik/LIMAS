<?php
require_once 'header.php';
$dir = './../language/' . $lang . '/users.json';
$file = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);
?>

<style type="text/css">#search{max-width:220px;float:right;}</style>
<div class="container" ondragstart="return false;" ondrop="return false;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top:7.5px;margin-right:2vh">
                        <a data-target="#ModalAdd" data-controls-modal="#ModalAdd" data-backdrop="static"
                        data-keyboard="false" data-toggle="modal" title="Add User" style="cursor: pointer">
                            <?=$arr['adduser']?>&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </h4>
                    <div class="input-group">
                        <input id="search" type="text" class="form-control" placeholder="<?=$arr['search']?>">
                        <div class="input-group-btn">
                            <button class="btn btn-default" id="btnSearch">
                                <i class="glyphicon glyphicon-search btnSearch" id="btnSearch"></i>
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

                <div class="panel-footer text-center" style="padding: 0 !important; height: 50px !important">
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
    </div>
</div>

<div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="AddLabel"><?=$arr['modaladd']['title']?></h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="formAddUser">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?=$arr['modaladd']['name']?></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" required autofocus autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><?=$arr['modaladd']['id']?></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="id" required autocomplete="off" />
                            <span class="help-block hidden" id="idcheck">
                                <strong>ID sudah ada yang pakai</strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><?=$arr['modaladd']['password']?></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" required autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><?=$arr['modaladd']['confirm']?></label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="confirm" required autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"><?=$arr['modaladd']['level']?></label>
                        <div class="col-md-6">
                            <select class="form-control selectpicker" name="level" title="Tingkatan">
                                <!--<option selected hidden disabled>Tingkatan</option>-->
                                <?php
                                foreach (PERMISSIONS as $key => $value) {
                                    echo "<option value='{$key}'>{$key}</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block hidden" id="levelcheck">
                                <strong>Mohon pilih tingkatan</strong>
                            </span>
                        </div>
                    </div>

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

<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="EditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="EditLabel"><?=$arr['modaledit']['title']?></h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="formEditUser">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['name']?></label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="name" required autofocus autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$arr['modaledit']['level']?></label>
                        <div class="col-md-7">
                            <select class="form-control" name="level">
                                <?php
                                foreach (PERMISSIONS as $key => $value) {
                                    echo "<option value='{$key}'>{$key}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id" value="">
                        <button type="submit" class="btn btn-success">
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

<div id="ModalDelete" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" style="text-align:center" id="messageDelete">
                    <?=$arr['modaldelete']['message']?>
                </h3>
            </div>

            <div class="modal-body" style="margin:0px;padding:10px;border-top:0px;text-align:center">
                <button type="button" class="btn btn-danger" id="btnDelete" onclick="">
                    <?=$arr['modaldelete']['btndelete']?>
                </button>
                <button type="button" class="btn btn-success" data-dismiss="modal">
                    <?=$arr['modaldelete']['btncancel']?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var currentpage = 0;
    var totalpages = 0;
    $(document).ready(function() {
        PopulateTable();
    });

    $(".modal").on("shown.bs.modal", function() {
        $(this).find("[autofocus]").focus();
    });

    $("#cbCheckAll").change(function() {
        var status = this.checked;
        $(".cbSingle").each(function() {
            this.checked = status;
        });
    });

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

    $("#formAddUser input[name='id']").on("focusout", function() {
        if ($(this).val()) {
            var query = {"action" : "checkid", "id" : $(this).val(), "key" : key};
            XAVIER({"processor" : "./../processor/setting_users", "data" : query}, function(data) {
                if (data) {
                    $("#idcheck").attr("class", "help-block");
                } else {
                    $("#idcheck").attr("class", "help-block hidden");
                }
            });
        }
    });

    $("#formAddUser button[type='reset']").click(function() {
        $("#formAddUser input[type='text']").val("");
    });

    $("#datatable").on('change', '.cbSingle', function() {
        if(this.checked == false) {
            $("#cbCheckAll")[0].checked = false;
        }

        if ($('.cbSingle:checked').length == $('.cbSingle').length ) {
            $("#cbCheckAll")[0].checked = true;
        }
    });

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
        $("#page").html("Sedang memuat");
        var query = {"action" : "populatetable", "search" : id, "page" : pagez, "key" : key};
        XAVIER({"processor" : "./../processor/setting_users", "data" : query}, function(data, status) {
            var items = [];
            if(data) {
                var butcher = $.parseJSON(data);
                var pages   = butcher["pages"];
                var xjson   = $.parseJSON(butcher["data"]);
            }
            $.each(xjson, function(index, value) {
                var string = value[0];
                var string = string.replace(/'/g, "\\'");
                var string = string.replace(/"/g, '\\"');
                items.push("<tr>");
                items.push(
                    "<td><input type='checkbox' class='cbSingle' id='" +
                    index + "' value='" + value[0] + "'></td>"
                );
                items.push("<td>" + value[0] + "</td>");
                items.push("<td>" + value[1] + "</td>");
                items.push("<td>" + value[2] + "</td>");
                items.push(
                    "<td>" +
                    "<a href='javascript:void(0)' onclick=\"EditUser('" + value[1] +
                    "')\"><?=$arr['table']['edit']?></a>&nbsp;" +
                    "<a href='javascript:void(0)' onclick=\"DeleteUser('" + value[1] +
                    "','" + string + "')\"><?=$arr['table']['delete']?></a>"
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

    function DeleteUser(id, name, mode) {
        if (mode && mode === "delete") {
            $("#btnDelete").attr("onclick", "");
            var query = {"action" : "singledelete", "identifier" : id};
            XAVIER({"processor" : "./../processor/setting_users", "data" : query}, function(data) {
                if (data === '1') {
                    $("#ModalDelete").modal("hide");
                    PopulateTable('','',currentpage);
                } else {
                    alert("SYSTEM ERROR");
                }
            });
        } else if (mode && mode === "multipledelete") {
            var ids = [];
            var query = {"action" : "multipledelete", "identifier" : ids[0]};
            XAVIER({"processor" : "./../processor/setting_users", "data" : query}, function(data) {
                if (data === "1") {
                    $("#ModalDelete").modal("hide");
                    PopulateTable();
                } else {
                    alert("SYSTEM ERROR");
                }
            });
        } else {
            $("#btnDelete").attr("onclick", "DeleteUser('"+id+"','','delete')");
            str = "<?=$arr['modaldelete']['message']?>";
            if ((str.match(/\{(.*?)\}/g)) == "{name}") {
                str = str.replace(/\{(.*?)\}/g, name);
            }
            $("#messageDelete").text(str);
            $("#ModalDelete").modal("show");
            /*$("#ModalDelete").modal({
                backdrop: "static",
                keyboard: false
            });*/
        }
    }

    $("#formAddUser").submit(function(event) {
        event.preventDefault();
        var $form = $(this),
            id       = $form.find("input[name='id']").val(),
            name     = $form.find("input[name='name']").val(),
            password = $form.find("input[name='password']").val(),
            confirm  = $form.find("input[name='confirm']").val(),
            level    = $form.find("select[name='level']").val();
        if (level) {
            var query = {"action" : "newuser", "key" : key, "id" : id, "name" : name, "password" : password, "confirm" : confirm, "level" : level};
            XAVIER({"processor" : "./../processor/setting_users", "data" : query}, function(data) {
                if (data === "1") {
                    $("#ModalAdd").modal("hide");
                    $("#formAddUser input[type='text']").val("");
                    PopulateTable();
                    currentpage = 0;
                } else if (data === "ERROR: 23000"){
                    alert("ID pengguna ada yang sama, silahkan masukkan ID pengguna lain");
                }
            });
        } else {
            $("#levelcheck").attr("class", "help-block");
        }
    });

    function EditUser(id, name) {
        var query = {"action" : "fillmodaledit", "identifier" : id};
        XAVIER({"processor" : "./../processor/setting_users", "data" : query, "key" : key}, function(data) {
            if (data) {
                var xobject = JSON.parse(data);
                var $form = $("#formEditUser");
                $form.find("input[name='id']").val(xobject[0]);
                $form.find("input[name='name']").val(xobject[1]);
                $form.find("select[name='level'] option[value='"+xobject[2]+"']").attr("selected", "selected");
                str = "<?=$arr['modaledit']['title']?>";
                if ((str.match(/\{(.*?)\}/g)) == "{name}") {
                    str = str.replace(/\{(.*?)\}/g, xobject[1]);
                }
                $("#EditLabel").text(str);
                //$("#ModalEdit").modal("show");
                $('#ModalEdit').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    }

    $("#formEditUser").submit(function(event) {
        event.preventDefault();
        var $form = $(this),
            id      = $form.find("input[name='id']").val(),
            name    = $form.find("input[name='name']").val(),
            level   = $form.find("select[name='level']").val();
        var query = {"action" : "savemodaledit", "id" : id, "name" : name, "level" : level};
        XAVIER({"processor" : "./../processor/setting_users", "data" : query, "key" : key}, function(data) {
            PopulateTable();
            $("#ModalEdit").modal("hide");
        });
    });

    function aaa() {
        $('input[type=checkbox]').each(function () {
            if (this.checked) {
                console.log($(this).val());
            }
        });
    }
</script>

<?php
require_once 'footer.php';
?>
