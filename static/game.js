let memberCount = 0;
let members = [];
let timeLast = 0;

$(function() {
  checkMembers();
  watchScore();
  // reflesh button
  const rbtn = $("#reflesh_btn");
  rbtn.click(function() {
    rbtn.prop("disabled", true);
    checkMembers();
  });
});

function checkMembers() {
  $.get(js_getMembers, function(src){
    showScore(src);
  })
}

function now() {
  const d = new Date();
  return d.getTime() / 1000; // same as unixtime
}

function watchScore() {
  // check score
  setTimeout(function() {
    if (now() - timeLast > 3) {
      checkMembers();
    }
    watchScore();
  }, 1000);
}

function showScore(src) {
  try {
    members = JSON.parse(src);
    timeLast = now();
    showTime();
    $("#reflesh_btn").prop("disabled", false);
  } catch (e) {
    console.log(e);
    console.log(src);
    return;
  }
  if (members.length != memberCount) {
    memberCount = members.length;
    return showScoreUI();
  }
  let info = [];
  for (let i = 0; i < members.length; i++) {
    const m = members[i];
    const member_id = m['member_id'];
    const score = m['score'];
    const name = m['name'];
    // check score
    const old_score = parseInt($(`#score${member_id}`).html());
    $(`#score${member_id}`).html(score);
    // effect?
    if (old_score != score) {
      info.push(name+"さんに1点!");
      $(`#box${member_id}`).css('backgroundColor', 'orange');
      setTimeout(function() {
        $(`#box${member_id}`).css('backgroundColor', 'white');
      }, 100);
    }
  }
  // info
  if (info.length > 0) {
    $('#info').html(info.join(" - "));
  }
}
function showScoreUI() {
  let h = "";
  for (let i = 0; i < members.length; i++) {
    const m = members[i];
    const member_id = m['member_id'];
    const score = m['score'];
    const name = m['name'];
    let msg = "";
    if (self_id == member_id) {
      msg = "(自分)";
    }
    h += 
      `<div id="box${member_id}" class='box score_box'>` +
      `<span>${msg}${name}</span> - ` +
      `<span id="score${member_id}" class='score'>${score}` +
      `</span>点 - ` +
      `<button id="btn${member_id}" class='pure-button' ` +
      ` onclick='addscore(${member_id})'>` +
      `いいね！</button>` + 
      `</div>`;
  }
  $("#members").html(h);
}
function addscore(member_id) {
  // check myself
  if (member_id == self_id) {
    const info = $('#info');
    info.html('自分にいいね！はできません。');
    info.css('backgroundColor', 'yellow');
    setTimeout(function() {
      info.css('backgroundColor', 'white');
    },300);
    return;
  }

  // addscore
  const url = js_addscore + "&member_id=" + member_id;
  $(`#btn${member_id}`).prop("disabled", true);
  $.get(url, function(src) {
    $(`#btn${member_id}`).prop("disabled", false);
    if (src == "null") {
      return $info.html("すみません。失敗。");
    }
    showScore(src);
  });
}

function z2(v) {
  const sv = "00" + v;
  return sv.substr(sv.length - 2, 2)
}
function showTime() {
  const d = new Date();
  d.getTime(timeLast * 1000);
  $("#timeLast").html(
    z2(d.getHours()) + ":" + z2(d.getMinutes()) + ":" + z2(d.getSeconds())
  );
}


