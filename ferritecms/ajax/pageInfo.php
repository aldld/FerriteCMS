<?php

// TODO: Check if the user is logged in

if (!isset($_GET['type']) || !isset($_GET['parent'])) {
    exit();
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
            <!-- URL up to slug here -->
            <input type="text" name="slug" id="ferritcms_pinfoslug" />
        </p>
        
        <p>
            <input type="submit" value="save" />
            or <a href="#" id="ferritecms_pinfocancel">Cancel</a>
        </p>
        
        <?php if ($_GET['type'] == 'edit'): ?>
        <p>
            <input type="button" id="ferritecms_pinfodelete" value="Delete" />
        </p>
        <?php endif; ?>
        
        <input type="hidden" name="parent" id="ferritecms_pinfoparent"
            value="<?php echo $_GET['parent']; ?>" />
        
    </form>
    
</div>
