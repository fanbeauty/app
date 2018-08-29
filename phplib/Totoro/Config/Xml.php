<?php
/**
 * User: Major
 * Date: 2018/4/28
 * Time: 17:06
 */

namespace Totoro\Config;

class Xml
{
    private $xml = null;

    public function __construct($xml_file)
    {
        if (!is_file($xml_file)) {
            throw new \Exception("can\'t open the {$xml_file}, please check the correctness of path");
        }
        $this->xml = simplexml_load_file($xml_file);
    }

    public function get($expression)
    {
        $list = $this->xml->xpath($expression);
        $data_set = array();
        if (count($list) == 1) {
            $data_set = self::normalizeSimpleXML($list[0]);
        } else {
            foreach ($list as $entry) {
                $data_set[] = self::normalizeSimpleXML($entry);
            }
        }
        return $data_set;
    }

    public function normalizeSimpleXML($obj)
    {
        if (is_a($obj, '\SimpleXMLElement')) {
            $obj_vars = get_object_vars($obj); //返回由对象属性组成的关联数组
            if (count($obj_vars) == 0) {
                return $obj->__toString();
            } else {
                $result = array();
                foreach ($obj_vars as $k => $v) {
                    $result[$k] = self::normalizeSimpleXML($v);
                }
                return $result;
            }
        } else {
            return $obj;
        }
    }
}
