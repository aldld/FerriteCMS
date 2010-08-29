<?php

require_once 'lib/Pages.php';

class tags_Page
{
    private $page;
    
    function __construct($id) {
        $this->page = Pages::getPage($id);
    }
    
    function id() {
        return $this->page->id;
    }
    
    function headTitle() {
        return $this->page->title;
    }
    
    function title() {
        $output = '<span class="ferritecms_title">' .
                  $this->page->title .
                  '</span>';
        
        return $output;
    }
    
    function content() {
        $output = '<div class="ferritecms_content">' .
                  $this->page->content .
                  '</div>';
        
        return $output;
    }
}

$requestURI = str_replace(BASE_PATH, '', $_SERVER['REQUEST_URI']);
$splitURI = explode('/', $requestURI);

// Remove empty segments from $requestURI
foreach ($splitURI as $key => $value) {
    if (is_null($value) || $value == '') {
        unset($splitURI[$key]);
    }
}

$page = null;
if (empty($splitURI)) {
    $page = new tags_Page(Pages::getID('home'));
} else {
    $pageID = Pages::getID(end($splitURI));
    $parent = null;
    foreach(array_reverse($splitURI) as $segment) {
        $id = Pages::getID($segment);
        if (!$id) {
            header('HTTP/1.0 404 Not Found');
            exit();
        }
        
        if (!is_null($parent)) {
            if ($id != $parent) {
                header('HTTP/1.0 404 Not Found');
                exit();
            }
        }
        
        $page = Pages::getPage($id);
        if ($page->parent != 0) {
            $parent = $page->parent;
        } else {
            $page = new tags_Page($pageID);
            break;
        }
        
        $page = null;
    }
}

if (is_null($page)) {
    header('HTTP/1.0 404 Not Found');
    exit();
}
