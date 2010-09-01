<?php
/**
 * FerriteCMS main configuration settings
 */

/**
 * The admin password, used to login to edit page content
 */
define('ADMIN_PASS', 'demo');

/**
 * Base URL of the site. This is NOT the ferritecms/ directory,
 * but the URL of the site itself.
 */
define('BASE_URL', 'http://localhost/cms/');

/**
 * Base path of FerriteCMS, relative to root.
 */
define('BASE_PATH', '/cms');

/**
 * The secret admin key to verify if a user is an admin, used along
 * with their username/password.
 *
 * TODO: Create an installer to generate a random ADMIN_ID
 */
define('ADMIN_ID', 'jrJ984Jfjaa4389uakl4309ajdf');

/**
 * Whether FerriteCMS is in development mode or not. Set this
 * to false when using in a production setting.
 */
define('DEV_MODE', true);
