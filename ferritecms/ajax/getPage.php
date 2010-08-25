<?php

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    exit();
}

define('CMS_ROOT', '../');
set_include_path(CMS_ROOT);

require_once 'config.php';
require_once 'lib/Pages.php';
$page = Pages::getPage($_GET['id']);

$output = '';
switch ($_GET['type']) {
    case 'content':
        $output = $page->content;
        break;
    
    case 'title':
        $output = $page->title;
        break;
    
    default:
        exit();
}

echo $output;

