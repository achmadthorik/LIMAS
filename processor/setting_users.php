<?php
session_start();
//$_POST['data'] = json_encode(array("action" => "populatetable", "search" => "", "page" => "0"));
if (!isset($_POST['data']) || null === $_POST['data']) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
require_once './../config.php';
require_once './../configuration/permission.php';
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
                'SELECT nama, id, tingkatan FROM pengguna WHERE nama LIKE :nama LIMIT 10 OFFSET ' . $page,
                array(':nama' => "%{$data['search']}%"),
                'FETCH_NUM'
            );
            $ouija = DB::select(
                'SELECT COUNT(id) FROM pengguna WHERE nama LIKE :nama',
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
        }
        break;

    case 'fillmodaledit':
        try {
            DB::connect();
            $output = DB::select(
                'SELECT id, nama, tingkatan FROM pengguna WHERE id=:id',
                array(':id' => $data['identifier']),
                'FETCH_NUM'
            )[0];
            echo json_encode($output);
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'savemodaledit':
        try {
            DB::connect();
            $query = '';
            $param = array(':id' => $data['id'], ':name' => $data['name'], ':level' => $data['level']);
            if (isset($data['password'])) {
                $query = 'UPDATE pengguna SET nama=:name, katasandi=:password,
                tingkatan=:level WHERE id=:id';
                $param[':password'] = $data['password'];
            } else {
                $query = 'UPDATE pengguna SET nama=:name, tingkatan=:level WHERE id=:id';
            }
            $output = DB::update($query, $param, 'SINGLE');
            echo '1';
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    case 'checkid':
        try {
            DB::connect();
            $output = DB::select(
                'SELECT id FROM pengguna WHERE id=:id',
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

    case 'newuser':
        try {
            DB::connect();
            if ($data['password'] === $data['confirm'] &&
                isset(PERMISSIONS[$data['level']]) ||
                array_key_exists(PERMISSIONS, $data['level'])
            ) {
                $output = DB::insert(
                    'INSERT INTO pengguna (id, nama, katasandi, tingkatan) VALUES (
                        :id, :name, :password, :level
                    )',
                    array(
                        ':id'     => $data['id'],
                        ':name'   => $data['name'],
                        ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                        ':level' => $data['level']
                    ),
                    'SINGLE'
                );
                echo '1';
            }
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getCode();
        } finally {
            DB::disconnect();
        }
        break;

    case 'singledelete':
        try {
            DB::connect();
            $output = DB::delete(
                'DELETE FROM pengguna WHERE id=:id',
                array(':id' => $data['identifier']),
                'SINGLE'
            );
            echo '1';
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
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
                'DELETE FROM pengguna WHERE id=:id',
                $identifier,
                'MULTIPLE_SQ'
            );
            echo "1";
        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            DB::disconnect();
        }
        break;

    default:
        $_SESSION[APPNAME]['access'] = '';
        unset($_SESSION[APPNAME]['access']);
        header('HTTP/1.0 403 Forbidden');
        exit;
        break;
}
