<?php

// TODO: Make sure the user is logged in and authorized

if (!isset($_POST['update']) || !isset($_POST['id']) || !isset($_POST['content'])) {
    exit();
}

$id = $_POST['id'];
$update = $_POST['update'];
$content = $_POST['content'];

define('CMS_ROOT', dirname(dirname(__file__)) . DIRECTORY_SEPARATOR);
set_include_path(CMS_ROOT);

require_once 'config.php';
require_once 'lib/Pages.php';
$page = Pages::getPage($id);

switch ($update) {
    case 'content':
        Pages::updatePage($page->id,
                          $page->title,
                          $content,
                          $page->slug,
                          $page->position,
                          $page->parent
                          );
        break;
    
    case 'title':
        Pages::updatePage(
                          $page->id,
                          $content,
                          $page->content,
                          $page->slug,
                          $page->position,
                          $page->parent
                          );
        break;
    
    default:
        exit();
}

echo 'Saved';
