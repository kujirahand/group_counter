<?php
// Read config
require_once 'group_counter.conf.php';

// Custom config
$file_config = __DIR__.'/user.config.php';
if (!file_exists($file_config)) {
  echo "<h1>No config file, Please make: user.config.php</h1>";
  exit;
} else {
  require_once($file_config);
}

// Read engine
require_once 'lib/index.lib.php';


