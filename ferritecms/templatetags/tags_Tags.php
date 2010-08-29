<?php

require_once 'lib/Pages.php';

/**
 * Class containing just some miscellaneous template tags.
 */
class tags_Tags
{
    function navList($depth = 0, $type = 'ul', $parent = 0, $parentSlug = '') {
        $list = Pages::pageList($parent);
        // Check if $list is empty or not
        if (empty($list)) {
            return '';
        }
        
        $output = '<' . $type . ' class="ferritecms_nav' . ($parent ? ' ferritecms_subnav' : '') . '">';
        foreach ($list as $li) {
            $output .= '<li id="ferritecms_nav-' . $li['id'] . '">';
            $output .= '<a href="' . BASE_URL . ($parentSlug ? $parentSlug . '/' : '') .
                        $li['slug'] . '">';
            $output .= $li['title'] . '</a>';
            
            // The next levels
            if ($depth != 1) {
                $output .= $this->navList(($depth ? $depth - 1 : 0), $type, $li['id'], $li['slug']);
            }
            
            $output .= '</li>';
        }
        $output .= '<li class="ferritecms_newpage" id="ferritecms_newparent-' .
                    $parent . '"><a href="#">New Page</a></li>';
        $output .= '</' . $type . '>';
        
        return $output;
    }
}
$tags = new tags_Tags();
