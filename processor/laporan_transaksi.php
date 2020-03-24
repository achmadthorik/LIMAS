<?php
session_start();
if (!isset($_POST['data']) || null === $_POST['data']) {
    header("HTTP/1.0 403 Forbidden");
    exit;
}
require_once './../config.php';
$_SESSION[APPNAME]['access'] = true;
require_once './database.php';
use LIMAS\Database\XAVIER as DB;

$data = json_decode($_POST['data'], true);
switch ($data['action']) {
    case 'populatetable':
        try {
            DB::connect();
            $page = (int)$data['page'];
            if ($data['page'] !== 0) {
                $page = ($page * 10);
            }
            $option_query = "";
            switch ($data['option']) {
                case 'semua':
                    $option_query = "";
                    break;

                case 'pinjam':
                    $option_query = "and detiltransaksi.tglpengembalian is null";
                    break;

                case 'kembali':
                    $option_query = "and detiltransaksi.tglpengembalian is not null";
                    break;

                default:
                    $option_query = "";
                    break;
            }
            $output = DB::select(
                "select idbuku, judul, count(judul) as jumlah, idanggota, idpengguna, idtransaksi
        from buku, detiltransaksi, transaksi
        where buku.id = detiltransaksi.idbuku
       {$option_query}
        and idbuku like :idbuku
        and transaksi.id = detiltransaksi.idtransaksi
        group by idbuku LIMIT 10 OFFSET ".$page,
                array(":idbuku" => "%{$data['search']}%"),
                "FETCH_NUM"
            );
            $ouija = DB::select(
                "select count(buku.id), judul, count(judul) as jumlah, idanggota, idpengguna, idtransaksi
      from buku, detiltransaksi, transaksi
      where buku.id = detiltransaksi.idbuku
     {$option_query}
      and idbuku like :idbuku
      and transaksi.id = detiltransaksi.idtransaksi",
                array(":idbuku" => "%{$data['search']}%"),
                "FETCH_NUM"
            );
            $pages = ceil((int)$ouija[0][0] /10);
            echo json_encode(array("pages" => $pages, "data" => json_encode($output)));
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;
    case 'populatetable2':
        try {
                DB::connect();
                $option_query = "";
            switch ($data['option']) {
                case 'semua':
                    $option_query = "";
                    break;

                case 'pinjam':
                    $option_query = "and detiltransaksi.tglpengembalian is null";
                    break;

                case 'kembali':
                    $option_query = "and detiltransaksi.tglpengembalian is not null";
                    break;

                default:
                    $option_query = "";
                    break;
            }
                $output = DB::select(
                    "SELECT namalengkap,date_format(tglpinjam,'%d-%M-%Y'),
                    date_format(tglharuskembali,'%d-%M-%Y'),
                    date_format(tglpengembalian,'%d-%M-%Y'),denda FROM
                     anggota, buku, transaksi, detiltransaksi
                     WHERE anggota.id = transaksi.idanggota
                     {$option_query}
                     AND transaksi.id = detiltransaksi.idtransaksi
                     AND buku.id = detiltransaksi.idbuku
                     AND buku.id = '{$data['id']}'",
                    array(""),
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

        break;
    default:
                $_SESSION[APPNAME]['access'] = '';
                unset($_SESSION[APPNAME]['access']);
                header('HTTP/1.0 403 Forbidden');
        exit;
                break;
}



/*
   "SELECT namalengkap,date_format(tglpinjam,'%d-%M-%Y'),
                    date_format(tglharuskembali,'%d-%M-%Y'),
                    date_format(tglpengembalian,'%d-%M-%Y'),denda,nama FROM
                     anggota, pengguna, buku, transaksi, detiltransaksi
                     WHERE anggota.id = transaksi.idanggota
                     AND transaksi.id = detiltransaksi.idtransaksi
                     AND buku.id = detiltransaksi.idbuku
                     AND buku.id = '{$data['id']}'",
                    array(""),
                    "FETCH_NUM"
*/