<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <?php include 'ferritecms/ferritecms.inc.php'; ?>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    
    <title><?php echo $page->headTitle(); ?></title>
</head>
<body>
    <div id="nav">
        <?php echo $tags->navList(); ?>
    </div>
    
    <h1><?php echo $page->title(); ?></h1>
    
    <div id="content">
        <?php echo $page->content(); ?>
    </div>
    
    <p>
        <strong><a class="ferritecms_editlink" href="#">Editor mode</a></strong>
    </p>
</body>
</html>
