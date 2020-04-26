<?php

function action_game_default() {
  global $DIR_STATIC;
  // check login
  if (empty($_SESSION['member_id'])) {
    return error_page('管理者から教えてもらった'.
      'URLにアクセスしてください。');
  }
  // ボタンを表示
  $js_getMembers = app_url("game", "getMembers");
  $js_addscore = app_url("game", "addscore");
  $file_game_js = $DIR_STATIC.'/game.js';
  $game_js_mtime = filemtime($file_game_js);
  //
  $name = $_SESSION['name'];
  $member_id = $_SESSION['member_id'];
  $group_id = $_SESSION['group_id'];
  $invite_url = app_url_full("join", "", [
    "group_id" => $group_id,
    "q" => $_SESSION['hash'],
  ]);
  // group
  $r = db_get("SELECT * FROM groups WHERE".
    " group_id=?", [$group_id]);
  if (!$r) {
    return error_page('グループが無効です');
  }
  $group = $r[0];
  $title = $group['title'];
  // render
  template_render('game.html',[
    "title" => $title,
    "name" => $name,
    "member_id" => $member_id,
    "group_id" => $group_id,
    "js_getMembers" => $js_getMembers,
    "js_addscore" => $js_addscore,
    "game_js" => "static/game.js?m=$game_js_mtime",
    "invite_url" => $invite_url,
  ]);
}

function action_game_getMembers() {
  $group_id = $_SESSION['group_id'];
  $r = db_get("SELECT * FROM members ".
    "WHERE group_id=? ORDER BY member_id ASC",
    [$group_id]);
  echo json_encode($r);
}

function action_game_addscore() {
  $member_id = intval(get_param("member_id"));
  if ($member_id == 0) {
    echo "false";
    return;
  }
  //
  db_exec("UPDATE members SET score=score+1 WHERE ".
    "member_id=?", [$member_id]);
  //
  return action_game_getMembers();
}

