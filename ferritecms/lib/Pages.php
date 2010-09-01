<?php

require_once 'lib/Database.php';
require_once 'lib/data/Page.php';

/**
 * Class handling database work involving pages
 */
class Pages
{
    /**
     * $initialized stores whether init() has been called; true
     * if it has been called at least once.
     */
    private static $initialized = false;
    
    /**
     * $db stores an instance of a PDO database object to connect
     * with the SQLite database. The instance is inserted into this
     * object when init() is called.
     */
    private static $db;
    
    /**
     * Stores a PDO instance in $db from Database when called. It
     * is meant to only be called once, at the bottom of this file.
     */
    public static function init() {
        if (!self::$initialized) {
            self::$db = Database::getInstance();
            self::$initialized = true;
        }
    }
    
    /**
     * Returns the slug of the page with the specified ID.
     */
    public static function getSlug($id) {
        $query = 'SELECT slug FROM pages WHERE id=:id LIMIT 1';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
        
        $row = $stmt->fetchObject();
        if ($row) {
            return $row->slug;
        }
        
        return false;
    }
    
    /**
     * Returns the ID of the page with the specified slug.
     */
    public static function getID($slug) {
        // Ensure a lowercase slug
        $slug = strtolower($slug);
        
        $query = 'SELECT id FROM pages WHERE slug=:slug LIMIT 1';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        
        $stmt->execute();
        
        $row = $stmt->fetchObject();
        if ($row) {
            return $row->id;
        }
        
        return false;
    }
    
    /**
     * Gets the title, content and slug of a page with the specified
     * ID, as a PDO data object.
     */
    public static function getPage($id) {
        $query = 'SELECT * FROM pages WHERE id=:id LIMIT 1';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
        
        $page = new Page();
        $stmt->setFetchMode(PDO::FETCH_INTO, $page);
        $stmt->fetch();
        
        return $page;
    }
    
    /**
     * Get an ordered array listing all pages with their titles and slugs.
     *
     * NOTE: This method was originally designed for a single-level page
     * hierarchy, and is thus inefficient when working with multi-level
     * page hierarchies, as it needs to hit the database multiple times
     * to generate a navigation list.
     *
     * TODO: Return the entire page hierarchy as a single array to generate
     * a navigation list.
     */
    public static function pageList($parent = 0) {
        $query = 'SELECT id, title, slug FROM pages
                    WHERE parent=:parent ORDER BY position ASC';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':parent', $parent);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Return the path to any given page, as a string.
     *
     * @return string The path
     */
    public static function getPath($id) {
        $query = 'SELECT slug, parent FROM pages WHERE id=:id';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch();
        
        $path = $row['slug'] . '/';
        if ($row['parent'] != 0) {
            $path = self::getPath($row['parent']) . $path;
        }
        
        return $path;
    }
    
    /**
     * Check if a slug is in use under a specific parent page. Replaces
     * getID() for checking if a slug is already in use.
     *
     * @param string $slug The slug to check
     * @param int $parent The parent page to check below
     * @return boolean Whether the slug is in use or not.
     */
    public static function slugExists($slug, $parent = null) {
        $slug = strtolower($slug);
        
        if (is_null($parent)) {
            $query = 'SELECT 1 FROM pages WHERE slug=:slug';
            $stmt = self::$db->prepare($query);
        } else {
            $query = 'SELECT 1 FROM pages WHERE slug=:slug AND parent=:parent';
            $stmt = self::$db->prepare($query);
            
            $stmt->bindParam(':parent', $parent);
        }
        
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        return (bool) $stmt->fetch();
    }
    
    /**
     * Inserts a new page into the database.
     *
     * @return mixed ID of the inserted row on success, false on failure.
     */
    public static function createPage($title, $content, $slug, $parent = 0, $position = null) {
        // Check to see if the slug is already in use
        if (self::slugExists($slug, $parent)) {
            return false;
        }
        
        // Get the position if it is not specified.
        if (is_null($position)) {
            $query = 'SELECT MAX(position) FROM pages WHERE parent=:parent';
            
            $stmt = self::$db->prepare($query);
            $stmt->bindParam(':parent', $parent);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $position = $row[0] + 1;
        }
        
        // Ensure a lowercase slug
        $slug = strtolower($slug);
        
        $query = 'INSERT INTO pages (title, content, slug, position, parent)
                    VALUES (:title, :content, :slug, :position, :parent)';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':parent', $parent);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        
        return self::$db->lastInsertId();
    }
    
    /**
     * Update the page with the given ID to match the specified parameters.
     */
    public static function updatePage($id, $title, $content, $slug, $position, $parent) {
        $query = 'UPDATE pages SET title=:title, content=:content, slug=:slug,
                    position=:position, parent=:parent WHERE id=:id';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':parent', $parent);
        
        $title = stripslashes($title);
        $content = stripslashes($content);
        $slug = stripslashes(strtolower($slug));
        
        $stmt->execute();
    }
    
    public static function deletePage($id) {
        
    }
}
Pages::init();
