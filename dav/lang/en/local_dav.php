<?php
// This file is part of Moodle - http://moodle.org/
//
// (c) Your Name / Your Org.

$string['pluginname'] = 'Local DAV (WebDAV integration)';
$string['picodavini'] = '.picodav.ini contents';
$string['picodavini_desc'] = 'Raw text to be written to moodledata/local_dav/.picodav.ini. You can paste entire PicoDAV configuration here. Example:
```
ANONYMOUS_READ = true
ANONYMOUS_WRITE = false
# ROOT = storage/dir```';
$string['wherefiles_title'] = 'Paths & endpoint';
$string['wherefiles_desc']  = 'The WebDAV endpoint will be available at: <code>{$a->web}</code><br>
The <code>.picodav.ini</code> will be stored under <code>moodledata/local_dav/.picodav.ini</code>.<br>
Files by default go to <code>moodledata/local_dav/storage</code> unless you set <code>ROOT</code> in the ini.';
