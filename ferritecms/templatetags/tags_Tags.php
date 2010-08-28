<?php

require_once 'lib/Pages.php';

/**
 * Class containing just some miscellaneous template tags.
 */
class tags_Tags
{
    function navList($type = 'ul', $depth = 1) {
        $list = Pages::pageList();
        $output = '';
        $output .= '<' . $type . ' class="ferritecms_nav">';
        foreach ($list as $li) {
            $output .= '<li id="ferritecms_nav-' . $li['id'] . '">' .
                        '<a href="' . BASE_URL . $li['slug'] . '">' .
                        $li['title'] . '</a></li>';
        }
        $output .= '</' . $type . '>';
        
        return $output;
    }
}
$tags = new tags_Tags();
