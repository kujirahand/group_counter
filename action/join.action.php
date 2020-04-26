<?php
function action_join_default() {
  global $APP_SALT;
  
  $group_id = intval(get_param("group_id"));
  $q = get_param("q"); // hash

  $r = db_get(
    "SELECT * FROM groups WHERE group_id=?",
    [$group_id]);
  if(!$r || count($r) == 0) {
    return error_page("指定のグループがありません。");
  }
  
  // title & password
  $title = $r[0]["title"];
  $password = $r[0]["password"];
  $ok_hash = md5($APP_SALT.$group_id.$password);
  if ($q != $ok_hash) {
    return error_page("URLが間違っています。".
      "グループの作成者にURLを尋ねてください。");
  }

  // save to session
  $_SESSION['group_id'] = $group_id;
  $_SESSION['hash'] = $q;
  template_render("join.html",[
    "group_id" => $group_id,
    "title" => $title,
  ]);
}

function action_join_go() {
  $name = trim(post_param('name'));
  $group_id = $_SESSION['group_id'];
  $hash = $_SESSION['hash'];
  $join_top_url= app_url("join", "", [
    "group_id" => $group_id,
    "q" => $hash,
  ]);
  if ($name == "") {
    return error_page(
      "名前が空です。".
      "<a href='$join_top_url'>こちらからもう一度入力</a>".
      "してください。");
  }
  $_SESSION['name'] = $name;

  // 既存の名前のメンバーがいたか？
  $r = db_get("SELECT * FROM members WHERE ".
    "group_id=? AND name=?", [$group_id, $name]);
  if ($r) {
    $member = $r[0];
    $_SESSION['member_id'] = $member['member_id'];
  } else {
    $db = db_exec("INSERT INTO members".
      "(group_id,name,ctime,mtime)".
      "VALUES(?,?,?,?)",[
        $group_id, $name, time(), time()]);
    $member_id = $db->lastInsertId();
    $_SESSION['member_id'] = $member_id;
  }
  redirect(app_url("game"));
}

