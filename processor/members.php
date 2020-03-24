<?php
session_start();
//$_POST['data'] = json_encode(array("action" => "populatetable", "search" => "", "page" => "0"));
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
                'SELECT * FROM anggota WHERE namalengkap LIKE :nama LIMIT 10 OFFSET ' . $page,
                array(':nama' => "%{$data['search']}%"),
                'FETCH_NUM'
            );
            $ouija = DB::select(
                'SELECT COUNT(id) FROM ANGGOTA WHERE namalengkap LIKE :nama',
                array(':nama' => "%{$data['search']}%"),
                'FETCH_NUM'
            );
            foreach ($output as $key1 => $value) {
                foreach ($value as $key2 => $data) {
                    $output[$key1][$key2] = htmlentities($data);
                }
            }
            //var_dump($output);
            $pages = ceil((int)$ouija[0][0] / 10);
            echo json_encode(array("pages" => $pages, "data" => json_encode($output)));
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
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
                'SELECT * FROM anggota WHERE id=:id',
                array(':id' => $data['identifier']),
                'FETCH_NUM'
            )[0];
            echo json_encode($output);
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
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
                'UPDATE anggota SET namalengkap=:nama, alamat=:alamat,
                telpon=:telpon WHERE id=:id',
                array(
                    ':nama'   => $data['name'],
                    ':alamat' => $data['address'],
                    ':telpon' => $data['phone'],
                    ':id'     => $data['id']
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

    case 'checkid':
        try {
            DB::connect();
            $output = DB::select(
                'SELECT id FROM anggota WHERE id=:id',
                array(':id' => $data['id']),
                'FETCH_NUM'
            );
            if (sizeof($output) !== 0) {
                echo "AA";
            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'newmember':
        try {
            DB::connect();
            $output = DB::insert(
                'INSERT INTO anggota (id, namalengkap, alamat, telpon) VALUES (
                    :id, :nama, :alamat, :telpon
                )',
                array(
                    ':id'     => $data['id'],
                    ':nama'   => $data['name'],
                    ':alamat' => $data['address'],
                    ':telpon' => $data['phone']
                ),
                'SINGLE'
            );
            echo 'success';
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getCode();
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
                'DELETE FROM anggota WHERE id=:id',
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
                'DELETE FROM anggota WHERE id=:id',
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
