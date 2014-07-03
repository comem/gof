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

    $templates = array();
    foreach (getAllFiles('.', 'html') as $filename) {
        $viewName = str_ireplace('.html', '', $filename);
        $viewName = str_ireplace('/', '_', $viewName);
        $content = file_get_contents($filename);
        $templates[$viewName] = preg_replace('/\s\s+/', ' ', $content);
    }
    $json = json_encode($templates);

    header("Content-type: application/javascript");
?>
var templates = <?php echo $json;?>;