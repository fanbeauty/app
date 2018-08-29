<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 18:02
 */

namespace Totoro\Mvc\Input;

use Totoro\Util\Security;

class AbstractInput
{
    private $dataSetRef;

    protected function __construct($data)
    {
        $this->dataSetRef = $data;
    }

    private static function deepRemoveXss(&$result)
    {
        if (is_array($result))
            foreach ($result as $k => $v)
                self::deepRemoveXss($result[$k]);
        else
            return Security::removeXss($result);
    }

    private function filterRequestParam($key, $type, $default)
    {
        $rnt = is_array($this->dataSetRef) && array_key_exists($key, $this->dataSetRef) ? $this->dataSetRef[$key] : null;
        if (!is_array($rnt)) {
            switch ($type) {
                case 'string':
                case 'original':
                    break;
                case 'int':
                case 'long':
                    $rnt = intval($rnt);
                    break;
                case 'float':
                case 'double':
                    $rnt = doubleval($rnt);
                    break;
                case 'array':
                    $rnt = [];
                    break;
                case 'boolean':
                    $rnt = strtolower($rnt);
                    $rnt = ($rnt == 'false') ? false : boolval($rnt);
                    break;
                default:
                    //带有安全过滤的字符串
                    $rtn = Security::removeXss($rnt);
                    break;
            }
        } else {
            ;
        }
        return $rnt;
    }

    public function getBoolean($key)
    {
        return $this->filterRequestParam($key, 'boolean', true);
    }

    public function getBooleanOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'boolean', $default);
    }

    public function getInt($key)
    {
        return $this->filterRequestParam($key, 'int', 0);
    }

    public function getIntOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'int', $default);
    }

    public function getLong($key)
    {
        return $this->filterRequestParam($key, 'long', 0);
    }

    public function getLongOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'long', $default);
    }

    public function getFloat($key)
    {
        return $this->filterRequestParam($key, 'float', 0.0);
    }

    public function getFloatOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'long', $default);
    }

    public function getDouble($key)
    {
        return $this->filterRequestParam($key, 'double', 0.0);
    }

    public function getDoubleOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'double', $default);
    }

    public function getString($key)
    {
        return $this->filterRequestParam($key, 'string', '');
    }

    public function getStringOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'string', $default);
    }

    public function getStringWithoutXss($key)
    {
        $rnt = $this->filterRequestParam($key, 'string', '');
        $rnt = Security::removeXss($rnt);
        return $rnt;
    }

    public function getStringWithoutXssOrElse($key, $default)
    {
        $rnt = $this->filterRequestParam($key, 'string', $default);
        $rnt = Security::removeXss($rnt);
        return $rnt;
    }

    public function getArray($key)
    {
        return $this->filterRequestParam($key, 'array', []);
    }

    public function getArrayOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'array', $default);
    }

    public function getRaw($key)
    {
        return $this->filterRequestParam($key, 'original', '');
    }

    public function getRawOrElse($key, $default)
    {
        return $this->filterRequestParam($key, 'original', $default);
    }

    public function getDataSet()
    {
        $dataSet = $this->dataSetRef;
        self::deepRemoveXss($dataSet);
        return $dataSet;
    }

    public function getRawDataSet()
    {
        return $this->dataSetRef;
    }
}
