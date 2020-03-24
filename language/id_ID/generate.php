<?php
$file = fopen('./login.json', 'r');
//$test = json_encode(array("login" => "masuk", "username" => "nama pengguna", "password" => "kata sandi"));
//fwrite($file, $test);
$contents = fread($file, filesize('./login.json'));
fclose($file);
echo "<pre>";
var_dump(json_decode($contents, true));
echo "</pre>";
