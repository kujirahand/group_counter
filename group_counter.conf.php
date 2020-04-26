<?php
// --------------------------------------------------------
// Config
// --------------------------------------------------------
// DIR
global $DIR_ROOT;
$DIR_ROOT = __DIR__;

// TEMPLATE
global $DIR_TEMPLATE, $DIR_TEMPLATE_CACHE, $TEMPLATE_PARAMS;
$DIR_TEMPLATE = $DIR_ROOT.'/template';
$DIR_TEMPLATE_CACHE = $DIR_ROOT.'/template_cache';
$TEMPLATE_PARAMS = [
  'APP_TITLE' => 'チームで遊べる他人に投票するシステム',
];

// DATA FILE
global $FILE_DATABASE, $DB_MAIN;
$FILE_DATABASE = $DIR_ROOT.'/data/counter.sqlite';
$DB_MAIN = null; // database.lib.phpで生成

// ROOTING
global $DIR_ACTION, $DIR_STATIC;
$DIR_ACTION = $DIR_ROOT.'/action';
$DIR_STATIC = $DIR_ROOT.'/static';

// ADMIN_EMAIL
global $ADMIN_EMAIL;
$ADMIN_EMAIL = 'web@kujirahand.com';

// SALT
global $APP_SALT;
$APP_SALT = 'f9jX2#jd5:';

