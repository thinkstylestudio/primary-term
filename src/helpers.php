<?php

/**
 * Print with formatting and Die. Used for debugging purpose.
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param string $text
 * @param string $label
 */
function prd($text = '', $label = '')
{
    echo '<pre>', "\n";
    echo '==', $label, '==', "\n";
    print_r($text);
    echo "\n", '</pre>', "\n\n";
    exit;
}

/**
 * Short function for print_r() with formatting. Used for debugging purpose.
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param string $text
 * @param string $label
 */
function pr($text, $label = '')
{
    echo '<pre>', "\n";
    echo '==', $label, '==', "\n";
    print_r($text);
    echo "\n", '</pre>', "\n\n";
}

/**
 * Prints all specified arguments with their variable name
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param  ...
 */
function pra()
{
    $args = func_get_args();

    if (_is_array($args)) {
        $counter = 1;
        foreach ($args as $val) {
            pr($val, $counter);
            $counter++;
        }
    }

}

/**
 * Prints all specified arguments with their variable name and exits
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param  ...
 */
function prad()
{
    $args = func_get_args();

    if (_is_array($args)) {
        $counter = 1;
        foreach ($args as $val) {
            pr($val, $counter);
            $counter++;
        }
    }
    exit;
}

/**
 * var dumps and dies
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param string $text
 * @param string $label
 */
function vd($text, $label = '')
{
    echo '<pre>', "\n";
    echo '==', $label, '==', "\n";
    var_dump($text);
    echo "\n", '</pre>', "\n\n";
}

/**
 * var dumps and dies
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param string $text
 * @param string $label
 */
function vdd($text, $label = '')
{
    echo '<pre>', "\n";
    echo '==', $label, '==', "\n";
    var_dump($text);
    echo "\n", '</pre>', "\n\n";
    exit;
}

/**
 * Logs any data
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param mixed  $data
 * @param string $label
 */
function logg($data, $label = '')
{
    $file = '/Users/soubhik/Documents/tmp/my-errors.log';
    error_log('========'.$label.'========'."\n", 3, $file);
    error_log(json_encode($data)."\n", 3, $file);
    error_log('========'.$label.'========'."\n\n", 3, $file);
}

/**
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param mixed $data
 *
 * @return string
 */
function pt($data)
{
    if (is_object($data)) {
        echo get_class($data);
    } elseif (is_bool($data)) {
        var_dump($data);
    } elseif (is_array($data)) {
        pr($data);
    } else {
        echo $data.' ['.gettype($data).']';
    }
}

/**
 * @author Soubhik Chatterjee <soubhik@chatterjee.pw>
 *
 * @param mixed $data
 *
 * @return string
 */
function ptd($data)
{
    if (is_object($data)) {
        echo get_class($data);
    } elseif (is_bool($data)) {
        var_dump($data);
    } elseif (is_array($data)) {
        pr($data);
    } else {
        echo $data.' ['.gettype($data).']';
    }

    exit(0);
}
