<?php
session_start();
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
                'SELECT judul
                FROM transaksi, detiltransaksi, buku
                WHERE
                    transaksi.idanggota = :id1 AND
                    detiltransaksi.idtransaksi = transaksi.id AND
                    detiltransaksi.tglpengembalian IS NULL AND
                    detiltransaksi.idbuku = buku.id AND
                    buku.id = :id2',
                array(':id1' => $data['id'][0], ':id2' => $data['id'][1]),
                "FETCH_NUM"
            );
            if (sizeof($output) === 1) {
                echo $output[0][0];
            } elseif (sizeof($output) === 0) {
                $check = DB::select(
                    'SELECT judul FROM buku WHERE id=:id',
                    array(':id' => $data['id'][1]),
                    "FETCH_NUM"
                );
                if (sizeof($check) === 1) {
                    echo "e404z";
                } else {
                    echo '0x0';
                }
            } else {
                echo '0x0';
            }
        } catch (Exception $e) {
            //echo 'ERROR: ' . $e->getMessage();
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
            $source2 = DB::select(
                'SELECT date_format(tglharuskembali, "%d %M %Y")
                FROM transaksi, detiltransaksi
                WHERE
                    transaksi.idanggota = :id AND
                    transaksi.id = detiltransaksi.idtransaksi AND
                    detiltransaksi.tglpengembalian IS NULL',
                array(':id' => $data['id']),
                'FETCH_NUM'
            );
            if (sizeof($output) === 1 && sizeof($source2) > 0) {
                echo json_encode(array($output[0][0], $source2[0][0]));
            } elseif (sizeof($output) === 1 && sizeof($source2) === 0) {
                echo '0';
            } elseif (sizeof($output) === 0) {
                echo '1';
            }
        } catch (Exception $e) {
            //echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'getdata':
        try {
            DB::connect();
            $source1 = DB::select(
                'SELECT namalengkap FROM anggota WHERE id=:id',
                array(':id' => $data['id']),
                'FETCH_NUM'
            );
            $source2 = DB::select(
                'SELECT idbuku, judul, date_format(tglharuskembali, "%d %M %Y - %H:%i")
                FROM transaksi, detiltransaksi, buku
                WHERE
                    transaksi.idanggota = :id AND
                    detiltransaksi.idtransaksi = transaksi.id AND
                    detiltransaksi.tglpengembalian IS NULL AND
                    detiltransaksi.idbuku = buku.id',
                array(':id' => $data['id']),
                'FETCH_NUM'
            );
            if (0== 0) {
                echo json_encode(array('name'=>$source1[0][0], 'data'=>json_encode($source2)));
            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'gettitles':
        try {
            DB::connect();
            $ids = implode(',', $data['id']);
            $output = DB::select(
                "SELECT id, judul FROM buku WHERE id IN ({$ids})",
                null,
                'FETCH_NUM'
            );
            if (0== 0) {
                echo json_encode(array('data'=>json_encode($output)));
            }
        } catch (Exception $e) {
            //echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'save':
        try {
            DB::connect();
                $duedate = DB::select('SELECT tglpinjam FROM transaksi, detiltransaksi WHERE transaksi.idanggota = :id AND transaksi.id = detiltransaksi.idtransaksi AND detiltransaksi.tglpengembalian IS NULL LIMIT 1', array(':id' => $data['memberid']), 'FETCH_NUM')[0][0];
                TR::savereturn($data['memberid'], $duedate, $data['books']);
            echo '1';
        } catch (Exception $e) {
            //echo $e->getMessage();
            echo '2';
        } finally {
            DB::disconnect();
        }
        break;
}
