<?php
// Минимизируем накладные расходы Moodle.
define('NO_MOODLE_COOKIES', true);
define('NO_OUTPUT_BUFFERING', true);

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

// Всегда держим .picodav.ini актуальным в moodledata/local_dav/.
$inipath = local_dav_sync_ini_from_config();

// На всякий случай подготовим дефолтный storage, если админ не указал ROOT в ini.
$storagedir = local_dav_default_storage_dir();

/**
 * ПОДКЛЮЧЕНИЕ PicoDAV 
 * добавляем поддержку чтения пути к ini, передаваемого через константу LOCAL_DAV_INI_PATH.
 */
define('LOCAL_DAV_INI_PATH', $inipath);
define('LOCAL_DAV_STORAGE_PATH', $storagedir);
require __DIR__ . '/picodav/index.php';
exit;
