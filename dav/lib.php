<?php

/**
 * Обновить файл конфигурации при сохранении настроек плагина.
 * Эта функция должна вызываться как callback при обновлении admin_setting (set_updatedcallback).
 * @return void
 */
function local_dav_after_config() {
    // This callback is attached to the admin setting and will write the
    // .picodav.ini file only when the admin updates the textarea. That
    // avoids rewriting the file on every request to /local/dav/index.php.
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
 * Вызывать только при сохранении настроек (через local_dav_after_config).
 * Возвращает путь к файлу ini.
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
