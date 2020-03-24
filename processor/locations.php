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
    case 'populatetable1':
        try {
            DB::connect();
            $page = (int)$data['page'];
            if ($data['page'] !== 0) {
                $page = ($page * 10);
            }
            $output = DB::select(
                'SELECT * from lokasi
                where id like :muncul
                or nama like :muncul
                or tempat like :muncul
                LIMIT 10 OFFSET '.$page,
                array(':muncul' => "%{$data['search']}%"),
                "FETCH_NUM"
            );
            $ouija = DB::select(
                'SELECT count(id) from lokasi
                where id like :muncul
                or nama like :muncul
                or tempat like :muncul',
                array(':muncul' => "%{$data['search']}%"),
                "FETCH_NUM"
            );
              $pages = ceil((int)$ouija[0][0] /10);
              echo json_encode(array("pages" => $pages, "data" => json_encode($output)));
            //echo json_encode($output);
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            DB::disconnect();
            $_SESSION[APPNAME]['access'] = '';
            unset($_SESSION[APPNAME]['access']);
        }
        break;

    case 'fillmodaledit':
        try {
            DB::connect();
            $output = DB::select(
                "SELECT nama, tempat from lokasi
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
                'UPDATE lokasi
                set
                id      = :id,
                nama    = :namalokasi,
                tempat  = :tempat
                where id = :id',
                array(
                  ":id"         => "{$data['id']}",
                  ":namalokasi" => "{$data['namalokasi']}",
                  ":tempat"     => "{$data['tempat']}"
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
    case 'newlocation':
        try {
            DB::connect();
            $output = DB::insert(
                'INSERT INTO lokasi (id, nama, tempat)
                VALUES (:id, :namalokasi, :tempat)',
                array(
                  ":id"         => "{$data['id']}",
                  ":namalokasi" => "{$data['namalokasi']}",
                  ":tempat"     => "{$data['tempat']}",
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
                'DELETE from lokasi
                where id = :id',
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
                  'DELETE from lokasi
                  where id = :id',
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

    default:
        $_SESSION[APPNAME]['access'] = '';
        unset($_SESSION[APPNAME]['access']);
        header('HTTP/1.0 403 Forbidden');
        exit;
        break;
}
