<?php
function action_NewGroup_default() {
  template_render('NewGroup.html', [
  ]);
}

function action_NewGroup_new() {
  global $APP_SALT;
  $title = post_param('title', '');
  $password = post_param('password', '');
  if ($title == '') {
    return error_page('タイトルが空です。'.
      '戻るボタンで戻ってください。');
  }
  // New Group
  $db = db_exec('INSERT INTO groups '.
    '(title,password,ctime,mtime)'.
    'VALUES(?,?,?,?)',[
      $title, $password, time(), time(),
    ]);
  $group_id = $db->lastInsertId();
  $_SESSION['group_id'] = $group_id;
  $hash = md5($APP_SALT.$group_id.$password);
  $group_url = app_url_full("join", "", [
    "q" => $hash,
    "group_id" => $group_id,
  ]);
  // render
  template_render('NewGroup_new.html', [
    "group_id" => $group_id,
    "group_url" => $group_url,
    "title" => $title,
  ]);
}

function action_NewGroup_show() {
  $group_id = intval(get_param('group_id'));

}



