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
    case 'populatetable_anggota':
        try {
            DB::connect();
            $page = (int)$data['page'];
            if ($data['page'] !== 0 ) {
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
                "SELECT anggos.id `id`, anggos.namalengkap `namalengkap`, (
            SELECT COUNT(*) FROM anggota, transaksi, detiltransaksi, buku
                    WHERE anggota.id = transaksi.idanggota
                        AND transaksi.id = detiltransaksi.idtransaksi
                        AND detiltransaksi.idbuku = buku.id
                        AND anggota.id = anggos.id GROUP BY anggota.id
            ) `jumlah`, (
                SELECT SUM(detiltransaksi.denda)
                    FROM anggota, transaksi, detiltransaksi, buku
                      WHERE anggota.id = transaksi.idanggota
                        AND transaksi.id = detiltransaksi.idtransaksi
                        AND detiltransaksi.idbuku = buku.id
                        AND anggota.id = anggos.id GROUP BY anggota.id
                    ) `denda`
                        FROM anggota anggos, transaksi, detiltransaksi, buku
                            WHERE anggos.id = transaksi.idanggota
                                AND transaksi.id = detiltransaksi.idtransaksi
                                AND detiltransaksi.idbuku = buku.id
                                AND anggos.namalengkap LIKE :muncul {$option_query}
                                GROUP BY transaksi.idanggota
                                LIMIT 10 OFFSET " . $page,
                                #and detiltransaksi.tglpengembalian is null#
                array(':muncul' => "%{$data['search']}%"),
                "FETCH_NUM"
            );

            $ouija = DB::select(
                "SELECT anggos.id
                        FROM anggota anggos, transaksi, detiltransaksi, buku
                            WHERE anggos.id = transaksi.idanggota
                                AND transaksi.id = detiltransaksi.idtransaksi
                                AND detiltransaksi.idbuku = buku.id
                                AND anggos.namalengkap LIKE :muncul
                                GROUP BY transaksi.id",
                array(':muncul' => "%{$data['search']}%"),
                "FETCH_NUM"
            );
            $pages = ceil(sizeof($ouija) / 10);
            echo json_encode(array("pages" => $pages, "data" => json_encode($output)));
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;

    case 'populatetable_anggota2':
        try {
                DB::connect();
                $output = DB::select(
                    "select buku.id ,judul, denda
                    FROM anggota, transaksi, detiltransaksi, buku
                    WHERE anggota.id = transaksi.idanggota
                    AND transaksi.id = detiltransaksi.idtransaksi
                    AND detiltransaksi.idbuku = buku.id
                    and transaksi.idanggota = '{$data['id']}'",
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
