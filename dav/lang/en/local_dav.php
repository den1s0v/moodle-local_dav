<?php
// This file is part of Moodle - http://moodle.org/
//
// (c) VSTU.

$string['pluginname'] = 'Local DAV (WebDAV integration)';
$string['picodavini'] = '.picodav.ini contents';
$string['picodavini_desc'] = 'Raw text to be written to moodledata/local_dav/.picodav.ini. You can paste entire PicoDAV configuration here. Example:
```
ANONYMOUS_READ = true
ANONYMOUS_WRITE = false
# ROOT = storage/dir```';
$string['wherefiles_title'] = 'Paths & endpoint';
$string['wherefiles_desc'] = 'The WebDAV endpoint will be available at: <code>{$a->web}</code><br>
The <code>.picodav.ini</code> will be stored under <code>moodledata/local_dav/.picodav.ini</code>.<br>
Files by default go to <code>moodledata/local_dav/storage</code> unless you set <code>ROOT</code> in the ini.';

// === New strings for instructions and ROOT validation ===
$string['wherefiles_instr_title'] = 'Instruction for WebDAV clients';
$string['wherefiles_instr_text'] = 'Use the WebDAV endpoint above. When connecting with external clients (WinSCP, Cyberduck, etc.) set the initial/remote path to <code>/local/dav/</code> so the client does not attempt to walk above the plugin root.';

$string['wherefiles_paths_title'] = 'Standard Moodle paths';

$string['wherefiles_rootcheck_title'] = 'ROOT validation';
$string['wherefiles_root_notset'] = '<em>ROOT not set in ini — default storage will be used.</em>';
$string['wherefiles_root_file'] = 'This path points to a file — incorrect.';
$string['wherefiles_root_exists'] = 'Directory exists. Readable: {$a->read}, Writable: {$a->write}.';
$string['wherefiles_root_creatable'] = 'Directory does not exist but can be created (permissions are ok).';
$string['wherefiles_root_uncreatable']= 'Directory cannot be found or created (no permissions).';
$string['wherefiles_root_parsed'] = 'Parsed <code>ROOT</code>: <code>{$a->raw}</code> → <code>{$a->path}</code>';
