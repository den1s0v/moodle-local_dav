<?php
// Этот файл — часть Moodle - http://moodle.org/
//
// (c) Ваша команда

$string['pluginname'] = 'Local DAV (интеграция WebDAV)';
$string['picodavini'] = 'Содержимое .picodav.ini';
$string['picodavini_desc'] = 'Текст, который будет записан в файл moodledata/local_dav/.picodav.ini. Сюда можно вставить полный конфиг PicoDAV. Пример:
ANONYMOUS_READ = true
ANONYMOUS_WRITE = false
# ROOT = storage';
$string['wherefiles_title'] = 'Пути и точка доступа';
$string['wherefiles_desc']  = 'Точка входа WebDAV: <code>{$a->web}</code><br>
Файл <code>.picodav.ini</code> сохраняется в <code>moodledata/local_dav/.picodav.ini</code>.<br>
Если в ini не задан <code>ROOT</code>, файлы по умолчанию будут в <code>moodledata/local_dav/storage</code>.';
