<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_dav', get_string('pluginname', 'local_dav'));

    // Большое текстовое поле для .picodav.ini (хранится в config, но файл создаём в moodledata).
    $defaultini = "ANONYMOUS_READ = true\nANONYMOUS_WRITE = false\n# ROOT = storage\n";
    $setting_picodav = new admin_setting_configtextarea(
        'local_dav/picodavini',
        get_string('picodavini', 'local_dav'),
        get_string('picodavini_desc', 'local_dav'),
        $defaultini,
        PARAM_RAW,
        80, 20
    );
    // Ensure ini is written only when admin updates the textarea.
    $setting_picodav->set_updatedcallback('local_dav_after_config');
    $settings->add($setting_picodav);

    // Подсказка с путями и дополнительной информацией.
    $weburl = $CFG->wwwroot . '/local/dav/index.php';
    $where_desc = get_string('wherefiles_desc', 'local_dav', ['web' => $weburl]);

    // Дополнительные инструкции для внешних клиентов и проверка ROOT (если задан).
    $extra = '<h4>' . get_string('wherefiles_title', 'local_dav') . '</h4>';
    $extra .= '<p>' . $where_desc . '</p>';
    $extra .= '<h5>Instruction for WebDAV clients</h5>';
    $extra .= '<p>Use the WebDAV endpoint above. When connecting with external clients (WinSCP, Cyberduck, etc.) set the initial/remote path to <code>/local/dav/</code> so the client does not attempt to walk above the plugin root.</p>';
    $extra .= '<h5>Standard Moodle paths</h5>';
    $extra .= '<p><code>$CFG->dataroot</code>: <code>' . $CFG->dataroot . '</code></p>';
    $extra .= '<p>Default plugin storage (if no <code>ROOT</code> in ini): <code>' . local_dav_default_storage_dir() . '</code></p>';

    // If admin provided ROOT in the ini, try to validate the path and show result.
    $cfgtext = (string) get_config('local_dav', 'picodavini');
    $rootpathmsg = '';
    if (preg_match('/^\s*ROOT\s*=\s*(.+)$/mi', $cfgtext, $m)) {
        $rawroot = trim($m[1], " \t\n\r\0\x0B\"'");
        // Interpret relative paths as relative to dataroot/local_dav by default.
        if (preg_match('/^(\/|[A-Za-z]:\\\\)/', $rawroot)) {
            $candidate = $rawroot;
        } else {
            $candidate = $CFG->dataroot . DIRECTORY_SEPARATOR . 'local_dav' . DIRECTORY_SEPARATOR . $rawroot;
        }
        $rootpathmsg .= '<p>Parsed <code>ROOT</code>: <code>' . s($rawroot) . '</code> -> <code>' . s($candidate) . '</code></p>';
        if (is_file($candidate)) {
            $rootpathmsg .= '<p style="color:orange;">Этот путь указывает на файл — это некорректно.</p>';
        } else if (is_dir($candidate)) {
            $rootpathmsg .= '<p>Папка существует. Чтение: ' . (is_readable($candidate) ? 'yes' : 'no') . '; Запись: ' . (is_writable($candidate) ? 'yes' : 'no') . '.</p>';
        } else {
            $parent = dirname($candidate);
            if (is_dir($parent) && is_writable($parent)) {
                $rootpathmsg .= '<p>Папка не существует, но может быть создана (права на создание в родительской папке есть).</p>';
            } else {
                $rootpathmsg .= '<p style="color:red;">Папку не удалось найти и её нельзя создать (нет прав в родительской папке).</p>';
            }
        }
    } else {
        $rootpathmsg .= '<p><em>ROOT не задан в ini — будет использоваться директория по умолчанию.</em></p>';
    }
    $extra .= '<h5>Проверка ROOT</h5>' . $rootpathmsg;

    $settings->add(new admin_setting_heading('local_dav_info2', '', $extra));

    $ADMIN->add('localplugins', $settings);
}
