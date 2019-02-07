<?php
function get_absolute_path($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $pos => $part) {
        if ('.' == $part) {
            continue;
        }
        elseif ($pos == 0 && $part == '~') {
            $absolutes[] = getenv("HOME");
        }
        elseif ($pos > 0 && $part == '~') {
            continue;
        }
        elseif ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return implode(DIRECTORY_SEPARATOR, $absolutes);
}

?>