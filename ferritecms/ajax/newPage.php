<?php

// TODO: Make sure user is logged in

define('CMS_ROOT', dirname(dirname(__file__)) . DIRECTORY_SEPARATOR);
set_include_path(CMS_ROOT);

require_once 'config.php';
require_once 'lib/Pages.php';

if (!isset($_POST['title']) || !isset($_POST['slug']) || !isset($_POST['parent'])) {
    exit();
}

$title = $_POST['title'];
$slug = $_POST['slug'];
$parent = $_POST['parent'];

$id = Pages::createPage($title, '', $slug, $parent);
if (!$id) {
    echo 1;
    exit();
}

$path = Pages::getPath($id);

$listItem = '<li id="ferritecms_nav-' . $id . '"><a href="' . BASE_URL . $path . '">' .
            $title . '</a></li>';

echo $listItem;
