<?php

// TODO: Check if the user is logged in

if (!isset($_GET['type']) || !isset($_GET['parent'])) {
    exit();
}
$type = $_GET['type'];
$parent = $_GET['parent'];

define('CMS_ROOT', dirname(dirname(__file__)) . DIRECTORY_SEPARATOR);
set_include_path(CMS_ROOT);

require_once 'config.php';
require_once 'lib/Pages.php';

$path = '';
if ($parent != 0) {
    $path = Pages::getPath($parent);
}

?>

<div id="<?php echo ($_GET['type'] == 'new') ? 'ferritecms_newform' : 'ferritecms_editpageinfo'; ?>"
    class="ferritecms_dialog ferritecms_pageinfo ">
    
    <form action="" method="post">
        
        <p>
            <label for="title">Page Title</label>
            <input type="text" name="title" id="ferritecms_pinfotitle" />
        </p>
        
        <p>
            <label for="slug">Link</label>
            <?php echo BASE_URL, $path; ?>
            <input type="text" name="slug" id="ferritcms_pinfoslug" />
        </p>
        
        <p>
            <input type="submit" value="save" />
            or <a href="#" id="ferritecms_pinfocancel">Cancel</a>
        </p>
        
        <?php if ($type == 'edit'): ?>
        <p>
            <input type="button" id="ferritecms_pinfodelete" value="Delete" />
        </p>
        <?php endif; ?>
        
        <input type="hidden" name="parent" id="ferritecms_pinfoparent"
            value="<?php echo $parent; ?>" />
        
    </form>
    
</div>
