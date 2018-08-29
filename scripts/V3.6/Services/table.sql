/*
1.hub表字段
    id 圈子id
    name 圈子名
    cover 封面
    desc 简介
    tag  标签----后续添加
    bulletin_board 公告栏
    post_num 帖子数
    follower_num 关注者
    vir_follower 虚拟关注者
    comment_num  评论总量
    vir_comment 虚拟评论
    page_view 查看量
    vir_view 虚拟查看量
    creator 创建人
    last_creator 最近修改人
    status 1 待发布 2 发布 3 删除 
    create_ts 创建时间
    update_ts 修改时间

2.hub_user_relation  圈子和用户关系表
    circle_id 圈子id 
    user_id 用户id
    status 状态 1 关注 2 取消关注
    create_ts 关注时间
    update_ts 修改时间

3.hub_post_relation 圈子和帖子关系
    circle_id 圈子id
    post_id 帖子id 
    create_ts 创建时间
    update_ts 修改时间

4.topic 话题表
    id 话题id
    name 名称
    cover 话题封面
    desc 话题简介
    comment_num 评论数
    page_view 查看数
    vir_comment 虚拟评论数
    vir_view 虚拟查看量
    in_circles 所属圈子
    creator 创建者 
    last_creator 最后修改者
    status 状态 1.发布 2.待发布 3.删除 
    create_ts 创建时间
    update_ts 修改时间

5.topic_post_relation 话题和帖子关系
    topic_id 话题id
    post_id 帖子id
    create_ts 
    update_ts 跟新时间

6.banner 表
    



圈子 circle
圈子用户关系表
*/
