<?php
// ログインに関する処理をまとめたもの
session_start();

function login_check() {
  if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] > 0) {
      return TRUE;
    }
  }
  return FALSE;
}

function login_try($email, $password) {
  $user = database_get_user_by_email($email);
  if (!$user) return FALSE;
  $pw_hash = $user['password'];
  if (password_verify($password, $pw_hash)) {
    // ok
    $_SESSION['login'] = time();
    $_SESSION['user'] = $user;
    return TRUE;
  }
  return FALSE;
}

function logout() {
  $_SESSION['login'] = 0;
  unset($_SESSION['login']);
  unset($_SESSION['user']);
}

function get_login_user_id() {
  if (login_check()) {
    return intval($_SESSION['user']['user_id']);
  }
  return 0;
}
function get_self_id() {
  return get_login_user_id();
}

function get_login_user_info() {
  if (login_check()) {
    return $_SESSION['user'];
  }
  return 0;
}

function login_set_backurl($url) {
  $_SESSION['backurl'] = $url;
}

function login_get_backurl($def = "") {
  $url = $def;
  if (isset($_SESSION['backurl'])) {
    $url = $_SESSION['backurl'];
    unset($_SESSION['backurl']);
  }
  return $url;
}






