<?php

// TODO: Make sure user is logged in

/*
 * Error status codes (until I can think of something better)
 * 0: Not all POST values set
 * 1: Slug already in use
 * 2: Empty field
 */

define('CMS_ROOT', dirname(dirname(__file__)) . DIRECTORY_SEPARATOR);
set_include_path(CMS_ROOT);

require_once 'config.php';
require_once 'lib/Pages.php';

if (!isset($_POST['title']) || !isset($_POST['slug']) || !isset($_POST['parent'])) {
    echo 0;
    exit();
}

$title = $_POST['title'];
$slug = $_POST['slug'];
$parent = $_POST['parent'];

if (empty($title) || empty($slug)) {
    echo 2;
    exit();
}

$id = Pages::createPage($title, '', $slug, $parent);
if (!$id) {
    echo 1;
    exit();
}

$path = Pages::getPath($id);

$listItem = '<li id="ferritecms_nav-' . $id . '"><a href="' . BASE_URL . $path . '">' .
            $title . '</a></li>';

echo $listItem;
