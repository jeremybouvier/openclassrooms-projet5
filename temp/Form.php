<?php
namespace app;

class Form
{

    private $data;

    private function __construct($data = array())
    {
        $this->data = $data;
    }

    public static function input($label,$name)
    {
        $content = '<label for = "'.$name.'">'.$label.'</label>'.'<br >'.'<input type="text" name="'.$name. '" 
        placeholder="'.$name.'"><br >';

        return $content;
    }

    public static function textarea($label,$name)
    {
        $content = '<label for = "'.$name.'">'.$label.'</label>'.'<br >'.'<input type="text" name="'.$name. '" 
        placeholder="'.$name.'"><br >';

        return $content;
    }

    public static function password($label, $name)
    {
        $content = '<label for = "'.$name.'">'.$label.'</label>'.'<br >'.'<input type="text" name="'.$name. '" ><br >';
        return $content;
    }

    public static function submit($name)
    {
        $content = '<input type="submit" value="'.$name.'"><br >';

        return $content;
    }
}