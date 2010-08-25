<?php

/**
 * Class that stores a page "datatype"
 */
class Page
{
    var $id;
    var $title;
    var $content;
    var $slug;
    
    /**
     * Instantiate the blog post object from an object returned
     * from the database.
     *
     * @param mixed $row Object returned from the database
     */
    function __construct($row=null) {
        if ($row) {
            $this->title = $row->title;
            $this->content = $row->content;
            $this->slug = $row->slug;
        }
    }
}
