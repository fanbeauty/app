<?php 
class FeCircleService extends CircleService {
    //1.前台@1  ==首页圈子广场==
    public function getSimpleList($user_id){
        $detail = $this->getList();
        //这里通过Derector来修改detail
        $de = new CircleDerector();
        $ret = $de->getfe1list($user_id,$detail);
        /*
        {
            'id',
            'title',
            'pic_url',
            'members',
            'is_attention'
        }
        */
    }

     //2.前台@2 ==全部圈子==
     public function getAllList($user_id){
        $detail = $this->detail();
        //通过Derector修饰
        $de = new CircleDerector();
        $ret = $de->getfe2list($user_id,$detail);
        $ret = new CircleDerector($user_id,$detail);        
        /*
        {
            'id'
            'pic_url'
            'title'
            'is_attention'
        }
        */
    }

    //3.前台@3 ==我关注的圈子==
    public function getMyList($user_id){
        $ret = $this->getAllList($user_id);
        foreach($ret){
            //只返回关注了的圈子
        }
    }
}