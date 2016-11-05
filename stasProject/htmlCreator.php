<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 31.10.2016
 * Time: 13:53
 */
class htmlCreator{
    static $title;

    /**
     * @return mixed
     */
    public static function getTitle()
    {
        return self::$title;
    }

    /**
     * @param mixed $title
     */
    public static function setTitle($title)
    {
        self::$title = $title;
    }
    static function createHtmlFile($arrayData,$modelName,$file,$name){
        ob_start();
        require('view/'.$modelName.'/header.php');
        require('view/'.$modelName.'/'.$file);
        require('view/'.$modelName.'/footer.php');
        $content = ob_get_contents();

        ob_end_clean();
        file_put_contents('result/'.$name.'.html',$content);
    }
}