<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_dav', get_string('pluginname', 'local_dav'));

    // Большое текстовое поле для .picodav.ini (хранится в config, но файл создаём в moodledata).
    $defaultini = "ANONYMOUS_READ = true\nANONYMOUS_WRITE = false\n# ROOT = storage\n";
    $settings->add(new admin_setting_configtextarea(
        'local_dav/picodavini',
        get_string('picodavini', 'local_dav'),
        get_string('picodavini_desc', 'local_dav'),
        $defaultini,
        PARAM_RAW,
        80, 20
    ));

    // Подсказка с путями.
    $settings->add(new admin_setting_heading(
        'local_dav_info',
        get_string('wherefiles_title', 'local_dav'),
        get_string('wherefiles_desc', 'local_dav', (object)[
            'web' => new moodle_url('/local/dav/index.php'),
        ])
    ));

    $ADMIN->add('localplugins', $settings);
}
