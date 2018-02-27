<?php

/**
 * Ouch error handler for PHP
 *
 * @package     Ouch
 * @author      Lotfio Lakehal <lotfiolakehal@gmail.com>
 * @copyright   2018 Lotfio Lakehal
 * @license     MIT
 * @link        https://github.com/lotfio-lakehal/ouch
 */

if( !function_exists('ds'))
{

    /**
     * ds() directory separator function
     *
     * @return string directory separator
     */
    function ds()
    {
        return DIRECTORY_SEPARATOR;
    }
}

if( !function_exists('ouch_root'))
{

    /**
     * root() directory function
     *
     * @return string root dir path
     */
    function ouch_root()
    {
        return dirname(__DIR__) . ds();
    }
}

if( !function_exists('ouch_assets'))
{
    /**
     * assets() function path
     *
     * @param null $file
     * @return string
     */
    function ouch_assets($file = null)
    {
        return ouch_root() . 'resources'. ds() .'assets' . ds() . $file;
    }
}

if(! function_exists('renderView'))
{
    /**
     * render view function
     *
     * @param $file
     * @param $errors
     * @return bool
     */
    function renderView($file, $errors)
    {
        return Ouch\Core\View::render($file, $errors);
    }
}

if(! function_exists('str_last'))
{
    /**
     * get last word from a string
     *
     * @param string $str string
     * @param string $del delimiter
     * @return void
     */
    function str_last($str, $del = "\\")
    {
        $str = explode($del, $str);
        return $str[count($str) - 1];
    }
}


if(!function_exists('readErrorFile'))
{
    /**
     * read error file function
     *
     * @param string $file error file
     * @param int    $line error line
     * @return void
     */
    function readErrorFile($file, $line)
    {
        $file = new SplFileObject($file);
        $file->fseek(1); // remove < to disable php from execution

        $start = 1;

        if($line >= 10){ $start = $line - 7; $file->seek($start);} // if long file seek 7 lines before error 

        while (!$file->eof()) {

            if($start >= $line + 5) break; // break if long file

            // remove php tag and add &lt;
            if($start == 1) { echo "&lt;" . $file->fgets(); $start++; continue;}


            // if line > 10 jump two steps to slove seek problem else count normally
            if($line >= 10){ 
    
                echo $start + 2 . ' - ' . $file->fgets();
                 
            } else{
                
                echo $start  . ' - ' . $file->fgets();

            }

            $start++;
        }
    
        $file = null;
    }
}

if (!function_exists('getallheaders'))
{
    /**
     * get all headers function
     * generally this function exisits in apache so it will be used only in ngnx
     *
     * @return array
     */
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_')
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}