<?php
    /*
    |--------------------------------------------------------------------------
    | Regroupe tout les vues en un seul fichier JavaScript
    |--------------------------------------------------------------------------
    |
    */
    function getAllFiles($dir, $ext)
    {
        $dirIterator = new RecursiveDirectoryIterator($dir);
        $fileIterator = new RecursiveIteratorIterator($dirIterator);
        $files = array();
        foreach ($fileIterator as $file) {
             if ($file->isFile() && strrpos($file->getPathname(), ".{$ext}")) {
                $filename = str_replace('\\', '/', $file->getPathname());
                $files[] = str_replace("{$dir}/", '', $filename);
             }
        }
        return $files;
    }
    header("Content-type: application/javascript");

    foreach (getAllFiles('.', 'js') as $filename) {
       echo file_get_contents($filename) . "\n";
   }

   
