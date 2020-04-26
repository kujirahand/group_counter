<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

require_once __DIR__ .'/template_engine.lib.php';
require_once __DIR__ .'/database.lib.php';
require_once __DIR__ .'/login.lib.php';
require_once __DIR__ .'/rooting.lib.php';
require_once __DIR__ .'/etc.lib.php';

// HTTPSにリダイレクト
$host = $_SERVER['HTTP_HOST'];
$scheme = $_SERVER['REQUEST_SCHEME'];
if ($scheme == 'http' && $host == 'haiku.uta.pw') {
    $uri = $_SERVER['REQUEST_URI'];
    $gourl = "https://{$host}{$uri}";
    header("Location: $gourl");
    echo "<HTML><BODY>Redirect: <a href='{$gourl}'>{$gourl}</a></BODY></HTML>";
    exit;
}
// go action
rooting_action();

