<?php
/**
 * Main FerriteCMS file to be included from the template file.
 * Handles loading page content and, if logged in, the page editing
 * features.
 *
 * This file should be included from within your template's <head> tags.
 */

// Set the include path here, to make them behave in a sane(r) manner
set_include_path(dirname(__file__));

// Store the path to the ferritecms in CMS_ROOT
define('CMS_ROOT', dirname(__file__) . DIRECTORY_SEPARATOR);

require_once 'config.php';
require_once 'templatetags/index.php';

// Check if user is admin, set the admin ID code
$adminID = '';
if (isset($_COOKIE['fcms_admin'])) {
    if ($_COOKIE['fcms_admin'] == ADMIN_ID) {
        $adminID = ADMIN_ID;
    }
}

Pages::pageList();

// End of PHP section, begin HTML/Javascript
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/ferritecms/media/css/ferritecms.css"
    type="text/css" media="screen" />

<script type="text/javascript">
var ferriteCMS_id = '<?php echo $adminID; ?>';
var baseURL = '<?php echo BASE_URL; ?>';
var basePath = '<?php echo BASE_PATH; ?>';
var pageID = <?php echo $page->id(); ?>;
</script>
<script src="<?php echo BASE_URL; ?>ferritecms/media/js/jquery.js"></script>
<script src="<?php echo BASE_URL; ?>ferritecms/media/js/cookie.js"></script>
<script src="<?php echo BASE_URL; ?>ferritecms/media/js/ferritecms.js"></script>
