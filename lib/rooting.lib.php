<?php
// rooting
function rooting_action() {
  global $DIR_ACTION;
  $action = empty($_GET['a']) ? 'index' : $_GET['a'];
  $detail = empty($_GET['d']) ? '' : $_GET['d'];
  $action = preg_replace('#[^a-zA-Z0-9]+#', '', $action); // 危険な文字は削除
  $detail = preg_replace('#[^a-zA-Z0-9]+#', '', $detail); // 危険な文字は削除
  // check action file
  $file = $DIR_ACTION."/$action.action.php";
  if (!file_exists($file)) {
    return template_render('error_system.html', [
      'msg'=>'URLの間違い:アクションが未定義']);
  }
  // check method
  include_once $file;
  if ($detail == '') { $detail = 'default'; }
  $method = "action_{$action}_{$detail}";
  if (!function_exists($method)) {
    return template_render('error_system.html', [
      'msg'=>'アクション関数が未定義: '.$method]);
  }
  call_user_func($method);
}

function app_url($action, $detail='', $params=[]) {
  $script_name = $_SERVER['SCRIPT_NAME'];
  $uri = $script_name."?a=$action";
  if ($detail != '') {
    $uri .= "&d=$detail";
  }
  if (count($params) > 0) {
    foreach ($params as $p => $v) {
      $v = urlencode($v);
      $uri .= "&$p=$v";
    }
  }
  return $uri;
}

function app_url_full($action, $detail='', $params=[]) {
  $uri = app_url($action, $detail, $params);
  $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'];
  return "{$protocol}://{$host}{$uri}";
}

function echo_url($action, $detail='', $params=[]) {
  echo app_url($action, $detail, $params);
}


