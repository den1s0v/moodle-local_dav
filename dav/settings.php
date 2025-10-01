<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    require_once(__DIR__ . '/lib.php');

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

    $setting = new admin_setting_configcheckbox(
        'local_dav/hide_sensitive_files',
        get_string('hide_sensitive_files', 'local_dav'),
        get_string('hide_sensitive_files_desc', 'local_dav'),
        1
    );
    $settings->add($setting);

    // Подсказка с путями и дополнительной информацией.
    $weburl = $CFG->wwwroot . '/local/dav/';
    $where_desc = get_string('wherefiles_desc', 'local_dav', ['web' => $weburl]);

    // Заголовки и инструкции.
    $extra = '<h4>' . get_string('wherefiles_title', 'local_dav') . '</h4>';
    $extra .= '<p>' . $where_desc . '</p>';

    $extra .= '<h5>' . get_string('wherefiles_instr_title', 'local_dav') . '</h5>';
    $extra .= '<p>' . get_string('wherefiles_instr_text', 'local_dav') . '</p>';
    $extra .= '<p>' . '<a target=_blank href="https://github.com/kd2org/picodav/blob/main/README.md#configuration">→ PicoDAV coniguration ←</a>' . '</p>';

    $extra .= '<h5>' . get_string('wherefiles_paths_title', 'local_dav') . '</h5>';
    $extra .= '<p><code>$CFG->dirroot</code>: <code>' . $CFG->dirroot . '</code></p>';
    $extra .= '<p><code>$CFG->dataroot</code>: <code>' . $CFG->dataroot . '</code></p>';
    $extra .= '<p>Default plugin storage (if no <code>ROOT</code> in ini): <code>' .
        local_dav_default_storage_dir() . '</code></p>';

    // Проверка ROOT.
    $cfgtext = (string) get_config('local_dav', 'picodavini');
    $rootpathmsg = '';
    if (preg_match('/^\s*ROOT\s*=\s*(.+)$/mi', $cfgtext, $m)) {
        $rawroot = trim($m[1], " \t\n\r\0\x0B\"'");
        // Интерпретируем относительные пути относительно moodledata/local_dav.
        if (preg_match('/^(\/|[A-Za-z]:\\\\)/', $rawroot)) {
            $candidate = $rawroot;
        } else {
            $candidate = $CFG->dataroot . DIRECTORY_SEPARATOR . 'local_dav' . DIRECTORY_SEPARATOR . $rawroot;
        }
        $rootpathmsg .= '<p>' . get_string('wherefiles_root_parsed', 'local_dav',
            ['raw' => $rawroot, 'path' => $candidate]) . '</p>';
        if (is_file($candidate)) {
            $rootpathmsg .= '<p style="color:orange;">' . get_string('wherefiles_root_file', 'local_dav') . '</p>';
        } else if (is_dir($candidate)) {
            $rootpathmsg .= '<p>' . get_string('wherefiles_root_exists', 'local_dav', [
                'read' => (is_readable($candidate) ? 'yes' : 'no'),
                'write' => (is_writable($candidate) ? 'yes' : 'no')
            ]) . '</p>';
        } else {
            $parent = dirname($candidate);
            if (is_dir($parent) && is_writable($parent)) {
                $rootpathmsg .= '<p>' . get_string('wherefiles_root_creatable', 'local_dav') . '</p>';
            } else {
                $rootpathmsg .= '<p style="color:red;">' . get_string('wherefiles_root_uncreatable', 'local_dav') . '</p>';
            }
        }
    } else {
        $rootpathmsg .= '<p>' . get_string('wherefiles_root_notset', 'local_dav') . '</p>';
    }

    $extra .= '<h5>' . get_string('wherefiles_rootcheck_title', 'local_dav') . '</h5>' . $rootpathmsg;

    $settings->add(new admin_setting_heading('local_dav_info2', '', $extra));

    $ADMIN->add('localplugins', $settings);
}
