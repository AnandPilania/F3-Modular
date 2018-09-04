<?php

function f3($key = null, $default = false)
{
	$f3 = Base::instance();
	return ($key ? (null !== $f3->get($key) ? $f3->get($key) : $default) : $f3);
}
function root_path($inner = '')
{
	return realpath(__DIR__.'/..').'/'.$inner;
}
function extension($file)
{
	return pathinfo($file, PATHINFO_EXTENSION);
}
function abort()
{
    f3()->abort();
}
function status($code = 404)
{
    f3()->error($code);
}
function reroute($where)
{
    f3()->reroute($where);
}
function is_api($path)
{
    if (is_string($path)) {
        return explode('/', $path)[1] === 'api';
    }
    return false;
}
function view($template, array $data = [])
{
	return Response::instance()->view($template, $data);
}
function response($key, $val = null)
{
	return Response::instance()->json($key, $val);
}
function template($layout, $f3)
{
    $loc = null;
    if(Str::contains($layout, '::')) {
        $module = explode('::', $layout)[0];
        foreach(explode(';', $f3->UI) as $path) {
            if(Str::contains($path, 'modules/'.$module) || Str::contains($path, str_ireplace('/', '', 'modules\/'.$module))) {
                $loc = str_ireplace($module.'::', '', $path.$layout);
                break;
            }
        }
    }else{
        $loc = $layout;
    }
    return $loc;
}
function generateKey($chiper = 'AES-256-CBC')
{
    return 'base64:'.generateEncKey($chiper);
}
function generateEncKey($chiper = 'AES-256-CBC')
{
	return base64_encode(random_bytes($cipher == 'AES-128-CBC' ? 16 : 32));
}
function generateToken($key = null, $length = 40, $algo = 'sha256')
{
    return hash_hmac('sha256', random($length), ($key?:f3()->SECRET));
}
function generateExpiryDate($ttl)
{
    $date = new DateTime();
    $date->add(new DateInterval('PT'.$ttl.'H'));
    return $date->format('Y-m-d H:i:s');
}
function generateIPayTransactionID($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
function random($length = 16)
{
    $string = '';
    while (($len = strlen($string)) < $length) {
        $size = $length - $len;
        $bytes = random_bytes($size);
        $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
    }
    return $string;
}
function hasExtension($file, $default = 'htm')
{
    return $file.'.'.(pathinfo($file, PATHINFO_EXTENSION) ?: $default);
}
function flash($message, $type = 'success')
{
    Flash::instance()->addMessage($message, $type);
}
function trans($key, $params = null)
{
    $f3 = f3();
    return $f3->format($f3->get($key), ($params ?: ''));
}
function error($error)
{
    if (null === $error) {
        return;
    }
    if (is_array($error)) {
        foreach ($error as $err) {
            if (is_array($err)) {
                foreach ($err as $e) {
                    flash($e, 'danger');
                }
            } else {
                flash($err, 'danger');
            }
        }
    } else {
        flash($error, 'danger');
    }
}
function dd($params, $die = false)
{
    var_dump($params);
    if($die) {
        die();
    }
}