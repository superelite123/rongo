<?php
namespace App\Helper;

trait CommonFunction{
    public function searchArray($attr,$val,$array)
    {
        foreach($array as $key  => $item)
        {
            if($item[$attr] == $val)
            {
                return $key;
            }
        }
        return -1;
    }
}
