<?php
// Этот файл — часть Moodle - http://moodle.org/
//
// (c) VSTU.

$string['pluginname'] = 'Local DAV (интеграция WebDAV)';
$string['picodavini'] = 'Содержимое .picodav.ini';
$string['picodavini_desc'] = 'Текст, который будет записан в файл moodledata/local_dav/.picodav.ini. Сюда можно вставить полный конфиг PicoDAV. Пример:
```
ANONYMOUS_READ = true
ANONYMOUS_WRITE = false
# ROOT = storage/dir```';
$string['wherefiles_title'] = 'Пути и точка доступа';
$string['wherefiles_desc'] = 'Точка входа WebDAV: <code>{$a->web}</code><br>
Файл <code>.picodav.ini</code> сохраняется в <code>moodledata/local_dav/.picodav.ini</code>.<br>
Если в ini не задан <code>ROOT</code>, файлы по умолчанию будут в <code>moodledata/local_dav/storage</code>.';

// === Новые строки для инструкций и проверки ROOT ===
$string['wherefiles_instr_title'] = 'Инструкция для клиентов WebDAV';
$string['wherefiles_instr_text'] = 'Используйте точку входа WebDAV выше. При подключении через внешние клиенты (WinSCP, Cyberduck и т. п.) укажите начальный/удалённый путь <code>/local/dav/</code>, чтобы клиент не пытался подняться выше корня плагина.';

$string['wherefiles_paths_title'] = 'Стандартные пути Moodle';

$string['wherefiles_rootcheck_title'] = 'Проверка ROOT';
$string['wherefiles_root_notset'] = '<em>ROOT не задан в ini — будет использоваться директория по умолчанию.</em>';
$string['wherefiles_root_file'] = 'Этот путь указывает на файл — это некорректно.';
$string['wherefiles_root_exists'] = 'Папка существует. Чтение: {$a->read}, Запись: {$a->write}.';
$string['wherefiles_root_creatable'] = 'Папка не существует, но может быть создана (права позволяют).';
$string['wherefiles_root_uncreatable']= 'Папка не найдена и её нельзя создать (нет прав).';
$string['wherefiles_root_parsed'] = 'Разобранный <code>ROOT</code>: <code>{$a->raw}</code> → <code>{$a->path}</code>';
