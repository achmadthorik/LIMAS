<?php
session_start();
if (!isset($_POST['data']) || null === $_POST['data']) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
require_once './../config.php';
$_SESSION[APPNAME]['access'] = true;
require_once './database.php';
use LIMAS\Database\XAVIER as DB;


$data = json_decode($_POST["data"], true);
switch ($data['action']) {
    case 'populatetable_result':
        try {
            DB::connect();
            $page = (int)$data['page'];
            if ($data['page'] !==0){
                $page = ($page * 10);
            }
            $output = DB::select(
                "select judul, jumlah, jenis, deskripsi from buku where judul like :muncul ORDER BY judul
                LIMIT 10 OFFSET ".$page,
                array(":muncul" => "%{$data['search']}%"),
                "FETCH_NUM"
            );
            $ouija = DB::select(
                "select COUNT(*) from buku WHERE judul LIKE :muncul",
                array(':muncul' => "%{$data['search']}%"),
                "FETCH_NUM"
            );
            $pages = ceil((int)$ouija[0][0] / 10);
            if (sizeof($output) === 0) {
                echo "noresult";
                exit();
            } else {
                echo json_encode(array("pages" => $pages, "data" => json_encode($output)));
            }
            //echo json_encode($output);
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;
    case 'populatetable_result2':
            try {
                    DB::connect();
                    $output = DB::select(
                        "select deskripsi from buku where judul like :muncul",
                        array(':muncul' => "%{$data['search']}%"),
                        "FETCH_NUM"
                    );
                    echo json_encode($output);
            } catch (Exception $e) {
                    echo $e->getMessage();
            } finally {
                    DB::disconnect();
                    $_SESSION[APPNAME]['access'] = '';
                    unset($_SESSION[APPNAME]['access']);
            }
        default:
                $_SESSION[APPNAME]['access'] = '';
                unset($_SESSION[APPNAME]['access']);
                header('HTTP/1.0 403 Forbidden');
                exit;
                break;
    }
