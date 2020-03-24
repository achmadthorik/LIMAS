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

$data = json_decode($_POST['data'], true);
switch ($data['action']) {
    case 'populatetable':
        try {
            DB::connect();
            $page = (int)$data['page'];
            if ($data['page'] !== 0) {
                $page = ($page * 10);
            }
            $output = DB::select(
                'SELECT buku.id, judul, deskripsi, jenis, jumlah, lokasi.nama FROM buku, lokasi
                where buku.idlokasi = lokasi.id
                and judul LIKE :carie
                LIMIT 10 OFFSET '.$page,
                array(':carie' => "%{$data['search']}%"),
                'FETCH_NUM'
            );
            $ouija = DB::select(
                "SELECT count(buku.id) FROM buku, lokasi
                where buku.idlokasi = lokasi.id
                and judul LIKE :carie",
                array(':carie' => "%{$data['search']}%"),
                'FETCH_NUM'
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

    case 'cek':
        try {
            DB::connect();
            $output = DB::select(
                "SELECT id from buku where id = :id",
                array(':id' => "{$data['search']}"),
                "FETCH_NUM"
            );
            if (sizeof($output) !== 0) {
                echo "success";;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'fillmodaledit':
        try {
            DB::connect();
            $output = DB::select(
                "SELECT judul, deskripsi, jenis, jumlah, idlokasi from buku
                where id = :id",
                array(':id' => $data['identifier']),
                "FETCH_NUM"
            );
            echo json_encode($output[0]);
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;
    case 'savemodaledit':
        try {
            DB::connect();
            $output = DB::update(
                'UPDATE buku
                set
                buku.id     = :id,
                judul       = :judul,
                deskripsi   = :deskripsi,
                jenis       = :jenis,
                jumlah      = :jumlah,
                idlokasi    = :idlokasi
                where id = :id',
                array(
                  ':id'        => "{$data['id']}",
                  ':judul'     => "{$data['title']}",
                  ':deskripsi' => "{$data['description']}",
                  ':jenis'     => "{$data['category']}",
                  ':jumlah'    => "{$data['jumlah']}",
                  ':idlokasi'  => "{$data['location']}",
                ),
                'SINGLE'
            );
            echo 'success';
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;

    case 'newbook':
        try {
            DB::connect();
            $output = DB::insert(
                'INSERT INTO buku (id, judul, deskripsi, jenis, jumlah, idlokasi)
                VALUES (:id, :judul, :deskripsi, :jenis, :jumlah, :idlokasi)',
                array(
                    ':id'        => "{$data['id']}",
                    ':judul'     => "{$data['title']}",
                    ':deskripsi' => "{$data['description']}",
                    ':jenis'     => "{$data['category']}",
                    ':jumlah'    => "{$data['jumlah']}",
                    ':idlokasi'  => "{$data['location']}"
                ),
                'SINGLE'
            );
            echo 'success';
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;

    case 'singledelete':
        try {
            DB::connect();
            $output = DB::delete(
                'DELETE FROM buku
                WHERE id=:id',
                array(':id' => $data['identifier']),
                'SINGLE'
            );
            echo 'success';
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;

    case 'multipledelete':
        try {
            $source = json_decode($data['identifier'], true);
            $identifier = array();
            foreach ($source as $value) {
                    array_push($identifier, array(':id' => $value));
            }
            DB::connect();
            $output = DB::delete(
                'DELETE FROM buku WHERE id=:id',
                $identifier,
                'MULTIPLE_SQ'
            );
            echo "success";
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;

    case 'pilihan':
        try {
            DB::connect();
            $xaxo = DB::select("select id, nama from lokasi group by id", null, 'FETCH_NUM');
            echo json_encode($xaxo);
        } catch (Exception $e) {
            echo "AAA";
        } finally {
            DB::disconnect();
        }
        break;

    default:
            header('HTTP/1.0 403 Forbidden');
        exit;
            break;
}
