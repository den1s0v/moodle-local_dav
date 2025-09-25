<?php
// Минимизируем накладные расходы Moodle.
define('NO_MOODLE_COOKIES', true);
define('NO_OUTPUT_BUFFERING', true);

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

// Do NOT rewrite .picodav.ini on every request — it should be written only when
// the admin updates the plugin settings. Use local_dav_after_config() as callback.
// Get path to the existing ini file (it may or may not exist yet).
$inipath = local_dav_ini_path();

// Prepare default storage dir if admin did not set ROOT in ini.
$storagedir = local_dav_default_storage_dir();

/**
 * ПОДКЛЮЧЕНИЕ PicoDAV 
 * добавляем поддержку чтения пути к ini, передаваемого через константу LOCAL_DAV_INI_PATH.
 */
define('LOCAL_DAV_INI_PATH', $inipath);
define('LOCAL_DAV_STORAGE_PATH', $storagedir);
require __DIR__ . '/picodav/index.php';
exit;
