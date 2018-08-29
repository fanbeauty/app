<?php

//获取数据

class CircleIntegrator {
    private $loader;
    public function __construct($loader){
        $loader = new CircleLoader(); //获取所有的圈子信息
    }
    //
    //获取所有的圈子
    public function getList()
    {
        $idlist = (DAO)->XXX;
        $ret = $this->loader->getDetail($idlist);
        return $ret;
    }
}
