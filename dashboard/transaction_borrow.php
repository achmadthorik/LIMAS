<?php
session_start();
require_once './../config.php';
$dir = './../language/' . $lang . '/transactions.json';
$file = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$arr = json_decode($contents, true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="border-radius: 0;margin-bottom:0px !important;border:none;box-shadow:none">
            <div class="panel-heading clearfix" style="border-top-left-radius:0;border-top-right-radius:0;border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom-left-radius:3px;border-bottom-right-radius:3px">
                <h4 class="panel-title pull-left" style="padding-top: 7.5px; padding-bottom: 7.5px;">
                <a style="cursor:pointer" onclick="nt();"><?=$arr['borrow']['newtransaction']?>&nbsp;<span class="glyphicon glyphicon-plus"></span></a>
                </h4>
            </div>

            <div class="panel-body" style="padding:12px 0 0 0 !important">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?=$arr['borrow']['transactiondata']['title']?>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="formMember">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <?=$arr['borrow']['transactiondata']['memberid']?>
                                        </label>

                                        <div class="col-md-8" id="userinput">
                                            <div class="input-group">
                                                <input name="memberid" type="text" class="form-control" autocomplete="off" autofocus>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default" id="btnok">
                                                        <?=$arr['borrow']['transactiondata']['btnok']?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8 hidden" id="useredit">
                                            <div class="input-group">
                                                <input name="memberid" type="text" class="form-control" disabled>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default" id="btnedit">
                                                        <?=$arr['borrow']['transactiondata']['btnedit']?>
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
                                        <label class="col-md-3 control-label">
                                            <?=$arr['borrow']['transactiondata']['duedate']?>
                                        </label>

                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input name="duedate" type="text" class="form-control" value="7" required>
                                                <span class="input-group-addon">
                                                    <?=$arr['borrow']['transactiondata']['days']?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="form-control">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?=$arr['borrow']['borrowbook']['title']?>
                            </div>
                            <div class="panel-body">
                                <div class="form-horizontal" id="formBook">
                                    <div class="form-group">
                                        <label for="bookid" class="col-md-3 control-label">
                                            <?=$arr['borrow']['borrowbook']['bookid']?>
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
                            <div class="panel-heading">
                                &nbsp;<?=$arr['borrow']['table']['listsofborrowedbooks']?>&nbsp;
                            </div>

                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;"><?=$arr['borrow']['table']['index']?></th>
                                            <th><?=$arr['borrow']['table']['bookid']?></th>
                                            <th><?=$arr['borrow']['table']['booktitle']?></th>
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

<div id="ModalAlert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;padding-left:0.9vw" id="alertmessage">ALERT MESSAGE</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<script>
    var number = 1;
    var member;
    var ids = [];

    function nt() {
        number = 1;
        member = null;
        ids = [];
        $("#tabledata").html("<tr></tr>");
        $("#formBook input[name='bookid']").val("");
        $("#formBook input[name='title']").val("");
        $("#formMember input[name='memberid']").val("");
        $("#formMember input[name='membername']").val("");
        var $form = $("#formMember"),
            userinput    = $form.find("#userinput"),
            useredit     = $form.find("#useredit");
        userinput.attr("class", "col-md-8");
        useredit.attr("class", "col-md-8 hidden");
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
        } else {
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

    $("#formMember").on("submit", function(event) {
        event.preventDefault();
        if (member && ids[0]) {
            var duedate = $("#formMember input[name='duedate']").val();
            var query = {"action" : "save", "memberid" : member, "userid" : "<?=substr(password_hash($_SESSION[APPNAME]['userid'], PASSWORD_DEFAULT), 7)?>", "books" : ids, "duedate" : duedate};
            XAVIER({"processor" : "./../processor/transaction_borrow", "data" : query}, function(data) {
                if (data === "1") {
                    alert("Sukses");
                    nt();
                } else {
                    alert("Gagal");
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
        var query = {"action" : "readbook", "id" : bookid.val(), "member" : member, "key" : key};
        XAVIER({"processor" : "./../processor/transaction_borrow", "data" : query}, function(data) {
            if (data) {
                if (data === "1") {
                    title.val("Buku ini belum dikembalikan oleh anggota tsb");
                } else if (data === "2") {
                    title.val("TKP HILANG GAN, BAHAYA :'(");
                } else {
                    if (mode == "read") {
                        title.val(data);
                    } else if (mode == "push") {
                        $("#tabledata tr:last").after("<tr><td>" + number +
                            "</td><td>" + bookid.val() + "</td><td>" + data +
                            "</td></tr>"
                        );
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
            useredit     = $form.find("#useredit");
        id = memberid.val();
        membername.val("Mencari...");
        var query = {"action" : "readmember", "id" : id, "key" : key};
        XAVIER({"processor" : "./../processor/transaction_borrow", "data" : query}, function(data) {
            if (data) {
                memberid.val(id);
                editmemberid.val(id);
                member = id;
                membername.val(data);
                if (mode == "push") {
                    userinput.attr("class", "col-md-8 hidden");
                    useredit.attr("class", "col-md-8");
                }
            } else {
                membername.val("Anggota tidak ditemukan");
            }
        });
    }
</script>
