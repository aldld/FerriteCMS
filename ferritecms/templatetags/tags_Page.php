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
                  '</div>';
        
        return $output;
    }
    
    function content() {
        $output = '<div class="ferritecms_content">' .
                  $this->page->content .
                  '</div>';
        
        return $output;
    }
}

// Initialize an instance of tags_Page
if (isset($_GET['page'])) {
    $id = Pages::getID($_GET['page']);
    
    // In the event of a 404
    if (!$id) {
        header('HTTP/1.0 404 Not Found');
        exit();
    }
} else {
    $id = Pages::getID('home');
}
$page = new tags_Page($id);
