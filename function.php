<?php
function dump(...$vars): void
{
    foreach ($vars as $var) {
        $var = is_string($var) ? htmlspecialchars($var) : $var;
        $debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $debug = array_reverse($debug);
        $file = $debug[0]['file'];
        $line = $debug[0]['line'];
        echo '<pre style="background-color: #333; color: white; padding: 4px; margin: 8px 0">';
        echo $file . ':' . $line . '<br>';
        var_dump($var);
        echo '</pre>';
    }
}

function dd(...$vars): void
{
    dump(...$vars);
    die;
}