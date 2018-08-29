<?php

class adminCircleService extends CircleService {
    //1.后端list
    public function getList(){
        $detail = $this->getList();
        $de = new CircleDerector();
        $de->getadmin1list($detail);
        {
            /*
            'id'
            'title'
            'post_num'
            'follower_num'
            'vir_follower'
            'comment_num'
            'vir_comment'
            'page_view'
            'vir_view'
            'creator'
            'create_ts'
            'last_creator'
            'update_ts'
            'status'
            /*
        }
    }
    //2.后端编辑前 list 
    
    {
       return $this->getList
    }
}