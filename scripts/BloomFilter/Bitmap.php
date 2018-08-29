<?php
/**
 * User: Major
 * Date: 2018/5/8
 * Time: 21:55
 */

/**
 * 大量数据去重 bitmap 位图法
 * Class Bitmap
 */
class Bitmap
{
    public function __construct(array $arr)
    {
        print_r($this->removeDuplicate($arr));
    }

    public function removeDuplicate($arr)
    {
        $unique = array();
        foreach ($arr as $value) {
            if (!array_key_exists($value, $unique)) {
                $unique[$value] = 1;
            }
        }
        return array_keys($unique);
    }
}

new Bitmap([1, 2, 3, 2, 12, 4, 1, 2, 5, 76, 8, 9, 31, 1, 3, 5, 6, 78, 9, 3, 4, 5, 5, 5, 5, 5, 5, 7, 8, 9]);