<?php
// How would you find files that begin with "0aH" and delete them given a folder (with subfolders)?
// Assume there are many files in the folder.

// Get folders & files
$prefix = '0aH';
$Directory = new RecursiveDirectoryIterator('/home/dlednik/GIT/bitbucket.com');
$Iterator = new RecursiveIteratorIterator($Directory);
$files = new RegexIterator($Iterator, '/'.$prefix.'.+/', RecursiveRegexIterator::GET_MATCH);

// This only returns possible candidates
// Still need to check if file begins with $prefix!!!
foreach($files as $file => $object) {
    try {
        $info = pathinfo($file);
        if (substr($info['filename'], 0, 3) === $prefix) {
            echo "Deleting " . $file . PHP_EOL;
            // Remove file
            unlink($file);
        }
    } catch(Exception $e) {
        echo 'Exception: ' . $file . PHP_EOL; 
        error_log($e); 
    } 
}

// This script does a search for all the paths that contain `0aH`, 
// then it finds the paths which files actually start with `0aH` and removes them.