<?php
session_start();
//$_POST['data'] = json_encode(array("action" => "read", "id" => 5));'
//$_POST['data'] = json_encode(array("action" => "save"));
if (!isset($_POST['data']) || null === $_POST['data']) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
require_once './../config.php';
require_once './database.php';
require_once './database_transaction.php';
use LIMAS\Database\XAVIER as DB;
use LIMAS\Database\Transaction as TR;

$data = json_decode($_POST['data'], true);
switch ($data['action']) {
    case 'readbook':
        try {
            DB::connect();
            $output = DB::select(
                'SELECT judul FROM buku WHERE id=:id AND jumlah >= 1',
                array(':id' => $data['id']),
                "FETCH_NUM"
            );
            $check = DB::select('SELECT * FROM transaksi, detiltransaksi WHERE transaksi.idanggota = :idanggota AND transaksi.id = detiltransaksi.idtransaksi AND detiltransaksi.tglpengembalian IS NULL AND detiltransaksi.idbuku = :idbuku', array(':idanggota' => $data['member'], ':idbuku' => $data['id']), 'FETCH_NUM');
            if (sizeof($output) === 1 && sizeof($check) === 0) {
                echo $output[0][0];
            } elseif (sizeof($output) === 1 && sizeof($check) !== 0) {
                echo '1';
            } else {
                echo '2';
            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'readmember':
        try {
            DB::connect();
            $output = DB::select(
                'SELECT namalengkap FROM anggota WHERE id=:id',
                array(':id' => $data['id'])
            );
            if (sizeof($output) === 1) {
                echo $output[0][0];
            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'save':
        try {
            DB::connect();
            $key = '$2y$10$' . $data['userid'];
            if (password_verify($_SESSION[APPNAME]['userid'], $key)) {
                TR::savetransaction($data['memberid'], $_SESSION[APPNAME]['userid'], $data['duedate'], $data['books']);
                //var_dump($data['books']);
                echo "1";
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
        } finally {
            DB::disconnect();
        }

        break;
}
