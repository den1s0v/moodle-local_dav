<?php

/**
 * Обновить файл конфигурации при сохранении настроек плагина.
 * @return void
 */
function local_dav_after_config() {
    // global $CFG;
    // $config = get_config('local_dav', 'picodavini');

    // $datadir = $CFG->dataroot . '/local_dav';
    // if (!file_exists($datadir)) {
    //     mkdir($datadir, $CFG->directorypermissions, true);
    // }

    // file_put_contents($datadir . '/.picodav.ini', $config);

    local_dav_sync_ini_from_config();
}


/**
 * Абсолютный путь к рабочей папке плагина в moodledata.
 * Пример: /var/www/moodledata/local_dav
 */
function local_dav_datadir(): string {
    global $CFG;
    return rtrim($CFG->dataroot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'local_dav';
}

/** Убедиться, что директория в moodledata существует, создать при необходимости. */
function local_dav_ensure_datadir(): string {
    global $CFG;
    $dir = local_dav_datadir();
    if (!is_dir($dir)) {
        @mkdir($dir, $CFG->directorypermissions ?? 0777, true);
    }
    return $dir;
}

/**
 * Путь к файлу .picodav.ini в moodledata.
 */
function local_dav_ini_path(): string {
    return local_dav_ensure_datadir() . DIRECTORY_SEPARATOR . '.picodav.ini';
}

/**
 * Синхронизировать содержимое .picodav.ini из настроек Moodle в файл moodledata/local_dav/.picodav.ini
 * Вызывайте при каждом запросе к /local/dav/index.php — это дешёво и надёжно.
 */
function local_dav_sync_ini_from_config(): string {
    $cfgtext = (string) get_config('local_dav', 'picodavini');
    $inipath = local_dav_ini_path();

    // Создадим файл, если нет, или перезапишем при изменении.
    $needwrite = true;
    if (is_file($inipath)) {
        $current = @file_get_contents($inipath);
        if ($current === $cfgtext) {
            $needwrite = false;
        }
    }
    if ($needwrite) {
        @file_put_contents($inipath, $cfgtext);
    }

    return $inipath;
}

/**
 * Гарантировать «рабочий» каталог для файлов (если админ не указал ROOT в ini).
 * По умолчанию используем moodledata/local_dav/storage
 */
function local_dav_default_storage_dir(): string {
    $base = local_dav_ensure_datadir();
    $dir  = $base . DIRECTORY_SEPARATOR . 'storage';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    return $dir;
}
