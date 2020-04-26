<?php

function action_index_default() {
  $db = database_get();
  // render
  template_render('index.html', [
  ]);
}

