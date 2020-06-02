<?php 
// 路由映射表
return array(
    array('GET|POST /((@cid:[0-9]+/)@page:[0-9]+)', 'frontend\Index:index'),

    array('GET /search', 'frontend\Index:search'),

    array('GET /read/@tid:[0-9]+', 'frontend\Index:read'),

    array('GET /changeSort/@cid/@page/@sort', 'frontend\Index:changeSort'),

    array('GET /newTopic', 'frontend\Index:newTopic'),

    array('GET /edit/topic/@tid:[0-9]+', 'frontend\Index:editTopic'),

    array('GET /user(/@uid:[0-9]+)', 'frontend\User:index'),

    array('GET /notice', 'frontend\User:notice'),

    array('GET /profile', 'frontend\User:profile'),

    array('GET /scores', 'frontend\User:scores'),

    array('GET /recharge/@money:[0-9]+', 'frontend\User:recharge'),

    array('GET /recharge/return', 'frontend\User:alipayReturn'),

    array('GET /user/topic/@uid:[0-9]+/@page:[0-9]+', 'frontend\User:getMoreTopic'),

    array('GET /user/reply/@uid:[0-9]+/@page:[0-9]+', 'frontend\User:getMoreReply'),

    array('GET /user/collection/@uid:[0-9]+/@page:[0-9]+', 'frontend\User:getMoreCollection'),

    array('GET /user/fans/@uid:[0-9]+/@page:[0-9]+', 'frontend\User:getMoreFans'),

    array('GET /get/whisper/@type:0|1/@page:[0-9]+', 'frontend\User:getMoreWhisper'),

    array('GET /logout', 'frontend\User:logout'),

    array('GET|POST /login(/@type:qq|weibo)', 'frontend\User:login'),

    array('GET|POST /register(/@type:qq|weibo)', 'frontend\User:register'),

    array('POST /add/topic', 'frontend\Post:addTopic'),

    array('POST /add/reply/@tid:[0-9]+', 'frontend\Post:addReply'),

    array('POST /do/praise/@tid:[0-9]+', 'frontend\Post:doPraise'),

    array('POST /do/collection/@tid:[0-9]+', 'frontend\Post:doCollection'),

    array('POST /do/read/@type', 'frontend\Post:doRead'),

    array('POST /do/reward/@tid:[0-9]+', 'frontend\Post:doReward'),

    array('POST /do/follow', 'frontend\User:doFollow'),

    array('POST /upgrade/vip/@type:[0-9]+', 'frontend\User:doUpgrade'),

    array('POST /deliver/whisper', 'frontend\User:deliverWhisper'),

    array('POST /save/profile', 'frontend\User:saveProfile'),

    array('POST /recharge/notify', 'frontend\User:alipayNotify'),

    array('POST /change/club/@tid:[0-9]+', 'frontend\Post:changeClub'),

    array('POST /top/topic/@tid:[0-9]+', 'frontend\Post:topTopic'),

    array('POST /lock/topic/@tid:[0-9]+', 'frontend\Post:lockTopic'),

    array('POST /delete/topic/@tid:[0-9]+', 'frontend\Post:deleteTopic'),

    array('POST /edit/topic/@tid:[0-9]+', 'frontend\Post:editTopic'),

    array('POST /delete/reply/@pid:[0-9]+', 'frontend\Post:deleteReply'),

    array('POST /delete/whisper', 'frontend\Post:deleteWhisper'),

    array('/uploads', 'frontend\Post:upload'),

    // 管理首页
    array('GET /admin', 'backend\Admin:index'),

    // 管理分类
    array('GET /admin/clubs', 'backend\Admin:clubs'),

    // 系统设置
    array('GET /admin/system', 'backend\Admin:system'),

    // 管理帖子
    array('GET /admin/topics(/@page:[0-9]+)', 'backend\Admin:topics'),

    // 管理主题
    array('GET /admin/replys(/@page:[0-9]+)', 'backend\Admin:replys'),

    // 管理用户
    array('GET /admin/users(/@page:[0-9]+)', 'backend\Admin:users'),

    // 链接管理
    array('GET /admin/links', 'backend\Admin:links'),

    // 用户积分详情
    array('GET /admin/user-score-records/@uid:[0-9]+', 'backend\User:getUserScoreRecords'),
);
