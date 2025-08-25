<?php
// Минимизируем накладные расходы Moodle.
define('NO_MOODLE_COOKIES', true);
define('NO_OUTPUT_BUFFERING', true);

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

// Всегда держим .picodav.ini актуальным в moodledata/local_dav/.
$inipath = local_dav_sync_ini_from_config();

// На всякий случай подготовим дефолтный storage, если админ не указал ROOT.
$storagedir = local_dav_default_storage_dir();

/**
 * ПОДКЛЮЧЕНИЕ PicoDAV 
 * добавляем поддержку чтения ini из пути, передаваемого через константу
 *      define('LOCAL_DAV_INI_PATH', $inipath);
 */
define('LOCAL_DAV_INI_PATH', $inipath);
define('LOCAL_DAV_STORAGE_PATH', $storagedir);
require __DIR__ . '/picodav/index.php';
exit;


/* 
// Пока PicoDAV не подключён — выводим простую страничку с диагностикой.
header('Content-Type: text/html; charset=utf-8');
http_response_code(503);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Moodle local_dav</title>
<style>
body{font:14px/1.4 system-ui,Segoe UI,Roboto,Arial,sans-serif;margin:32px;}
code,pre{background:#1111; padding:2px 4px; border-radius:4px;}
.kv{margin:6px 0}
</style>
</head>
<body>
<h1>local_dav</h1>
<p>Плагин установлен. Теперь подключите ваш PicoDAV.</p>
<div class="kv"><b>Конфиг (.picodav.ini):</b> <code><?php echo htmlspecialchars($inipath, ENT_QUOTES); ?></code></div>
<div class="kv"><b>Рабочая директория (по умолчанию):</b> <code><?php echo htmlspecialchars(local_dav_default_storage_dir(), ENT_QUOTES); ?></code></div>
<p>Дальше: положите ваш PicoDAV в <code>local/dav/picodav/index.php</code> и раскомментируйте вызов лоадера в этом файле.</p>
</body>
</html>
*/
