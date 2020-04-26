// menu.js

var menu_b = false
function toggle_menu() {
  menu_b = !menu_b
  if (menu_b) {
    $('.menu').fadeIn(500)
  } else {
    $('.menu').fadeOut(300)
  }
}
// menu hide
$(function() {
  $('.menu').hide()
})

