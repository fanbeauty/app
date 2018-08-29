<?php

abstract class CircleService {
    //1.
    public function getList(); //获取所有的圈子信息
    {
        $loader = new CircleLoader();
        $ret = (new CicleIntegrator($loader))->getList();
        return $ret; //这里返回所有圈子的详细信息
    }
}
