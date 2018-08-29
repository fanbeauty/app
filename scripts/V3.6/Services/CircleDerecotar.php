<?php
class CircleDerecotar {
    //前端装饰1
    //前端装饰2 
    public function getFrontListid($user_id,$detail){
        //判断此用户是否关注了此圈子
        $user_id 用户id 
        $detail['id'] 圈子id
    }

    //前端3，只返回 关注的圈子
    public function myList($user_id,$detail){
        //只返回关注了的圈子
    }

    //后端装饰1
    public function getList(){
        //unset()
    }
}