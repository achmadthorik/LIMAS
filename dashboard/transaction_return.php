<?php
session_start();
require_once './../config.php';
$dir = './../language/' . $lang . '/transactions.json';
$file = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);
?>
<style type="text/css">#search{max-width:400px;float:right;}</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="border-radius: 0;margin-bottom:0px !important;border:none;box-shadow:none">
            <div class="panel-heading clearfix" style="border-top-left-radius:0;border-top-right-radius:0;border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom-left-radius:3px;border-bottom-right-radius:3px">
                <h4 class="panel-title pull-left" style="padding-top: 7.5px; padding-bottom: 7.5px;">
                <a style="cursor:pointer" onclick="nt();"><?=$arr['return']['newtransaction']?>&nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                </h4>
            </div>

            <div class="panel-body" style="padding:12px 0 0 0 !important">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?=$arr['return']['transactiondata']['title']?>
                            </div>
                            <div class="panel-body">
                                <div class="form-horizontal" id="formMember">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <?=$arr['return']['transactiondata']['memberid']?>
                                        </label>

                                        <div class="col-md-8" id="userinput">
                                            <div class="input-group">
                                                <input name="memberid" type="text" class="form-control" autocomplete="off" autofocus>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default" id="btnok">
                                                        <?=$arr['return']['transactiondata']['btnok']?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8 hidden" id="useredit">
                                            <div class="input-group">
                                                <input name="memberid" type="text" class="form-control" disabled>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default" id="btnedit">
                                                        <?=$arr['return']['transactiondata']['btnedit']?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="user" class="col-md-3 control-label"></label>

                                        <div class="col-md-8">
                                            <input name="membername" type="text" class="form-control" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-default btn-block"
                                            data-loading-text="Menyimpan..." autocomplete="off">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?=$arr['return']['returnbook']['title']?>
                            </div>
                            <div class="panel-body">
                                <div class="form-horizontal" id="formBook">
                                    <div class="form-group">
                                        <label for="bookid" class="col-md-3 control-label">
                                            <?=$arr['return']['returnbook']['bookid']?>
                                        </label>

                                        <div class="col-md-8">
                                            <input name="bookid" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-md-3 control-label"></label>

                                        <div class="col-md-8">
                                            <input name="title" type="text" class="form-control" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="submit" class="btn btn-primary btn-block"
                                            data-loading-text="Menambahkan..." autocomplete="off">
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix" style="padding-top:3px;padding-bottom:3px;">
                                <span class="pull-left" style="padding-top:5px;" id="xsx">&nbsp;<?=$arr['return']['table']['listsofborrowedbooks']?>&nbsp;</span>
                                <div class="input-group" id="search">
                                    <button class="btn btn-default btn-sm" id="btntableborrow" onclick="TableSwitcher('borrow')">
                                        Dipinjam
                                    </button>&nbsp;
                                    <button class="btn btn-default btn-sm" id="btntablereturn" onclick="TableSwitcher('return')">
                                        Akan dikembalikan
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;"><?=$arr['borrow']['table']['index']?></th>
                                            <th><?=$arr['borrow']['table']['bookid']?></th>
                                            <th><?=$arr['borrow']['table']['booktitle']?></th>
                                            <th id="duedate"><?=$arr['return']['table']['duedate']?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var number = 1;
    var member;
    var ids = [];
    var books = [];
    var current = "borrow";

    function nt() {
        number = 1;
        member = null;
        ids = [];
        books = [];
        current = "borrow";
        $("#tabledata").html("<tr></tr>");
        $("#formBook input[name='bookid']").val("");
        $("#formBook input[name='title']").val("");
        $("#formMember input[name='memberid']").val("");
        $("#formMember input[name='membername']").val("");
        $("#xsx").html("&nbsp;<?=$arr['return']['table']['listsofborrowedbooks']?>&nbsp;");
        var $form = $("#formMember"),
            userinput    = $form.find("#userinput"),
            useredit     = $form.find("#useredit"),
            duedate      = $form.find("input[name='duedate']");
        userinput.attr("class", "col-md-8");
        useredit.attr("class", "col-md-8 hidden");
        duedate.val("-");
    }

    $("#formBook input[name='bookid']").on("change paste keyup", function(event) {
        if (event.which == 13) {
            if ($(this).val()) {
                ReadBooks("push");
            }
        } else {
            if ($(this).val()) {
                ReadBooks("read");
            } else {
                $("#formBook input[name='title']").val("");
            }
        }
    });

    $("#formBook button[type='submit']").click(function() {
        if ($("#formBook input[name='bookid']").val()) {
            ReadBooks("push");
        } else {
            $("#formBook input[name='title']").val("");
        }
    });

    $("#formMember input[name='memberid']").on("change paste keyup", function(event) {
        if (event.which == 13) {
            if ($(this).val()) {
                ReadMember("push");
            }
        } else if (typeof event.which !== "undefined"){
            if ($(this).val()) {
                ReadMember("read");
            } else {
                $("#formMember input[name='membername']").val("");
            }
        }
    });

    $("#formMember #btnok").click(function() {
        if ($("#formMember input[name='memberid']").val()) {
            ReadMember("push");
        }
    });

    $("#formMember #btnedit").click(function() {
        var $form = $("#formMember"),
            userinput    = $form.find("#userinput"),
            useredit     = $form.find("#useredit");
        userinput.attr("class", "col-md-8");
        useredit.attr("class", "col-md-8 hidden");
        $("#formMember input[name='memberid']").focus();
    });

    $("#formMember button[type='submit']").click(function(event) {
        event.preventDefault();
        if (member && ids[0]) {
            var query = {"action" : "save", "memberid" : member, "books" : ids};
            XAVIER({"processor" : "./../processor/transaction_return", "data" : query}, function(data) {
                if (data) {
                    if (data === "1") {
                        alert("Sukses");
                        nt();
                    } else {
                        alert("Gagal");
                        //alert(data);
                    }
                }
            });
        }
    });

    function ReadBooks(mode) {
        var $form = $("#formBook"),
            bookid = $form.find("input[name='bookid']"),
            title  = $form.find("input[name='title']");
        $.each(ids, function(index, value) {
            if (bookid.val() === value) {
                title.val("Maksimal 1 buku bro");
                throw "exit";
            }
        });
        title.val("Mencari...");
        var $btn = $("#formBook button[type='submit']");
        if (mode == "push") {
            $btn.button("loading");
        }
        var identifier = [$("#formMember input[name='memberid']").val(), bookid.val()];
        var query = {"action" : "readbook", "id" : identifier, "key" : key};
        XAVIER({"processor" : "./../processor/transaction_return", "data" : query}, function(data) {
            if (data) {
                if (data === "e404z") {
                    title.val("Buku sedang tidak dipinjam oleh agan ini");
                } else if (data === "0x0") {
                    title.val("TKP HILANG GAN, BAHAYA :'(");
                } else {
                    if (mode === "read") {
                        title.val(data);
                    } else if (mode === "push") {
                        if (current === "borrow") {
                            $("#tabledata").html("<tr></tr>");
                            current = "return";
                        }
                        $("#tabledata tr:last").after("<tr><td>" + number +
                            "</td><td>" + bookid.val() + "</td><td>" + data +
                            "</td></tr>"
                        );
                        $("#xsx").html("&nbsp;<?=$arr['return']['table']['listsofbookswanttoreturn']?>&nbsp;");
                        $("th[id='duedate']").attr("class", "hidden");
                        //ids.push({"id" : bookid.val()});
                        ids.push(bookid.val());
                        bookid.val("");
                        title.val("");
                        number++;
                    }
                }
            }
            $btn.button("reset");
        });
    }

    function ReadMember(mode) {
        var $form = $("#formMember"),
            memberid     = $form.find("#userinput input[name='memberid']"),
            editmemberid = $form.find("#useredit input[name='memberid']"),
            membername   = $form.find("input[name='membername']"),
            userinput    = $form.find("#userinput"),
            useredit     = $form.find("#useredit"),
            duedate      = $form.find("input[name='duedate']");
        id = memberid.val();
        var query = {"action" : "readmember", "id" : id, "key" : key};
        if (mode === "push") {
            membername.val("Memproses data...");
        } else {
            membername.val("Mencari...");
        }

        XAVIER({"processor" : "./../processor/transaction_return", "data" : query}, function(data) {
            if (data) {
                if (data === '0') {
                    membername.val("Anggota tidak meminjam apapun");
                } else if (data === '1') {
                    membername.val("Anggota tidak ditemukan");
                } else {
                    memberid.val(id);
                    editmemberid.val(id);
                    member = id;
                    var xn = $.parseJSON(data);
                    if (mode == "push") {
                        userinput.attr("class", "col-md-8 hidden");
                        useredit.attr("class", "col-md-8");
                        duedate.val(xn[1]);
                        TableSwitcher("borrow", xn[0]);
                    } else {
                        membername.val(xn[0]);
                    }
                }
            }
        });
    }

    function TableSwitcher(mode, name) {
        var q;
        switch (mode) {
            case "return":
                q = {"action" : "gettitles", "id" : ids, "key" : key};
                current = "return";
                $("#xsx").html("&nbsp;<?=$arr['return']['table']['listsofbookswanttoreturn']?>&nbsp;");
                $("th[id='duedate']").attr("class", "hidden");
                break;

            case "borrow":
                var id = $("#formMember #userinput input[name='memberid']").val();
                q = {"action" : "getdata", "id" : id, "key" : key};
                current = "borrow";
                $("#xsx").html("&nbsp;<?=$arr['return']['table']['listsofborrowedbooks']?>&nbsp;");
                $("th[id='duedate']").attr("class", "");
                break;

            default:

        }
        if (q["id"][0]) {
            var num = 1;
            XAVIER({"processor" : "./../processor/transaction_return", "data" : q}, function(data) {
                if (data) {
                    var x = $.parseJSON($.parseJSON(data)["data"]);
                    var items = [];
                    $("#tabledata").html("");
                    $.each(x, function(index, value) {
                        items.push("<tr>");
                        items.push("<td>"+num+"</td>");
                        items.push("<td>" + value[0] + "</td>");
                        items.push("<td>" + value[1] + "</td>");
                        if (mode === "borrow") {
                            items.push("<td>" + value[2] + "</td>");
                        }
                        items.push("</tr>");
                        num++;
                    });
                    var y = items.join("");
                    $("#tabledata").html(y);
                    if (name) {
                        $("#formMember input[name='membername']").val(name);
                    }
                }
            });
        }
    }
</script>
