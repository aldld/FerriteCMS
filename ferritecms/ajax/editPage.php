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
        $output = '<form id="ferritecms_contentform" action="" method="post">' .
                    '<div><textarea id="ferritecms_contentfield">' .
                    $page->content .
                    '</textarea></div>' .
                    '<div><input type="submit" name="submit" value="Save" /></div>' .
                  '</form>';
        break;
    
    case 'title':
        $output = '<form id="ferritecms_titleform" action="" method="post">' .
                    '<div><input id="ferritecms_titlefield" name="title" type="text" value="' .
                    $page->title .
                    '" /> <input type="submit" name="submit" value="Save" /></div>' .
                  '</form>';
        break;
    
    default:
        exit();
}

echo $output;
