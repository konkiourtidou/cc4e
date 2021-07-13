<?php
if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../index.php");
    return;
}


use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "../tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

if ( U::get($_SESSION,'id', null) === null ) {
    die('Must be logged in');
}

require_once "sandbox.php";
require_once "enable.php";

/*
$ip = $_SERVER['REMOTE_ADDR'] ?? false;
if ( ! is_string($ip) ) die('No REMOTE_ADDR');

$public = filter_var(
    $ip, 
    FILTER_VALIDATE_IP, 
    FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
);

if ( is_string($public) ) {
	die('bad address');
}
 */

$code = $_POST['code'] ?? false;
$input = $_POST['input'] ?? false;
if ( ! is_string($code) ) die('No code');

$now = str_replace('@', 'T', gmdate("Y-m-d@H:i:s"));
$folder = sys_get_temp_dir() . '/compile-' . $now . '-' . md5(uniqid());
$folder = '/tmp/compile';
if ( file_exists($folder) ) {
    system("rm -rf $folder/*");
} else {
    mkdir($folder);
}
$env = array(
    'some_option' => 'aeiou',
    'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
);

$docker_command = $docker_command ?? 'docker run --network none --rm -i alpine_gcc:latest "-"';
$retval = cc4e_compile($code, $input, $folder, $env, $docker_command);
    
header("Content-type: application/json; charset=utf-8");
echo(json_encode($retval, JSON_PRETTY_PRINT));

$debug = true;
if ( $debug && isset($retval->assembly->stdout) && is_string($retval->assembly->stdout) ) {
    echo("\n");
    echo($retval->assembly->stdout);
}
