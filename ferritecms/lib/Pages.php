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
    
    public static function createPage($title, $content, $slug) {
        // Ensure a lowercase slug
        $slug = strtolower($slug);
        
        $query = 'INSERT INTO pages (title, content, slug)
                    VALUES (:title, :content, :slug)';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':slug', $slug);
        
        $stmt->execute();
    }
    
    public static function updatePage($id, $title, $content, $slug) {
        $query = 'UPDATE pages SET title=:title, content=:content, slug=:slug
                    WHERE id=:id';
        
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':id', $id);
        
        $title = stripslashes($title);
        $content = stripslashes($content);
        $slug = stripslashes(strtolower($slug));
        
        $stmt->execute();
    }
    
    public static function deletePage($id) {
        
    }
}
Pages::init();
