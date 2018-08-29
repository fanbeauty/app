<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 21:53
 */

namespace App\Controllers\api\common;

use App\Mvc\Controller;

class homedataController extends Controller
{
    public function v1Action()
    {
        $name = self::$GET->getString('name');
        $age = self::$GET->getInt('age');

        $data = array(
            'name' => $name,
            'age' => $age
        );
        return $this->jsonData($data);
    }
}
