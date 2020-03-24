<?php
require_once "header.php";
$dir = './../language/' . $lang . '/transactions.json';
$file = fopen($dir, 'r');
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
                        <li role="presentation" id="borrow">
                            <a data-toggle="tab" href="#cborrow" id="borrow">
                                <?=$arr['tabs']['borrow']?>
                            </a>
                        </li>
                        <li role="presentation" id="return">
                            <a data-toggle="tab" href="#creturn" id="return">
                                <?=$arr['tabs']['return']?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="cborrow" class="tab-pane fade">
                            <div id="borrowcontainer"></div>
                        </div>
                        <div id="creturn" class="tab-pane fade">
                            <div id="returncontainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //$("li#borrow").attr("class", "active");
        //$("a#borrow").attr("aria-expanded", true);
        activaTab("cborrow");
        $("#borrowcontainer").load("./transaction_borrow.php");
    });
    $("a#borrow").click(function() {
        $("#returncontainer").html("");
        $("#borrowcontainer").load("./transaction_borrow.php");
    });
    $("a#return").click(function() {
        $("#borrowcontainer").html("");
        $("#returncontainer").load("./transaction_return.php");
    });
    function activaTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };
</script>
<?php
require_once "footer.php";
?>
