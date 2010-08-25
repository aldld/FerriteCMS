<?php

// Automatically load all template tag classes.
foreach (glob(CMS_ROOT . 'templatetags/tags_*.php') as $filename) {
    require_once $filename;
}
