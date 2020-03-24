<?php
session_start();
//////////////////////////// GUARDIAN OF THE GALAXY \\\\\\\\\\\\\\\\\\\\\\\\\\\\
$key = substr(session_id(), 4, 13).'ru048a6rf86'.substr(session_id(), 2, 20);
$data = isset($_POST['data']) ? json_decode($_POST['data'], true) : ['key' => ''];
$key2 = '$2y$10$' . $data['key'];
if (!password_verify($key, $key2)) {
    header('HTTP/1.0 404 Not Found');
    exit();
}
//============================================================================\\
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__)));
}
require_once __ROOT__ . '/config.php';
require_once __ROOT__ . '/processor/database.php';
use LIMAS\Database\XAVIER as DB;

if (isset($data['userid'], $data['password'])) {
    try {
        DB::connect();
        $result = DB::select(
            "SELECT id, nama, katasandi, tingkatan, opsi
            FROM pengguna WHERE id=:user LIMIT 1",
            array(":user" => $data['userid']),
            "FETCH_NUM",
            "return"
        );
        if (sizeof($result) === 1) {
            if (password_verify($data['password'], $result[0][2])) {
                /*$dir = './language/' . $lang . '/login.json';
                $file = fopen($dir, 'r');
                $contents = fread($file, filesize($dir));
                fclose($file);
                $arr = json_decode($contents, true);*/
                $usersettings = json_decode($result[0][4], true);
                $usersettings['session'] = session_id();
                $modified = json_encode($usersettings);
                DB::update(
                    'UPDATE pengguna SET opsi=:usersettings WHERE nama=:user',
                    array(':usersettings' => $modified, ':user' => $result[0][1]),
                    'SINGLE',
                    null
                );
                $_SESSION[APPNAME]['userid'] = $result[0][0];
                $_SESSION[APPNAME]['name'] = $result[0][1];
                $_SESSION[APPNAME]['level'] = $result[0][3];
                $key = substr(
                    password_hash(
                        substr($result[0][1], 0, 3) .
                        session_id() .
                        substr($result[0][1], -2, 4) .
                        substr(session_id(), -4, 9) .
                        substr($result[0][1], -7, 2),
                        PASSWORD_DEFAULT
                    ),
                    7
                );
                //setcookie('key', $key);
                echo 'MATCH';
            } else {
                echo 'MISMATCH';
            }
        } else {
            echo 'MISMATCH';
        }
    } catch (Exception $e) {
        echo "ERROR";
    } finally {
        DB::disconnect();
    }
}
