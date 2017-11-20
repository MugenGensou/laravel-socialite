<?php

return [

    /**
     * Enable mock user.
     */
    'enable_mock' => env('SOCIALITE_ENABLE_MOCK', false),

    /**
     * Mock user.
     */
    'mock_user'   => [
        'open_id'  => 'ob4lr0nfQDLoICVSY08pDydxZing',
        'nickname' => 'Mugen Aki',
        'sex'      => '1',
    ],

    /**
     * Service lists
     */
    'providers'   => [

        /**
         * Wiki:
         */
        'facebook'    => [
            'client_id'     => env('SOCIALITE_FACEBOOK_APP_ID'),
            'client_secret' => env('SOCIALITE_FACEBOOK_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => explode(',', env('SOCIALITE_FACEBOOK_SCOPES')),
        ],

        /**
         * Wiki:
         */
        'github'      => [
            'client_id'     => env('SOCIALITE_GITHUB_APP_ID'),
            'client_secret' => env('SOCIALITE_GITHUB_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => explode(',', env('SOCIALITE_GITHUB_SCOPES')),
        ],

        /**
         * Wiki:
         */
        'google'      => [
            'client_id'     => env('SOCIALITE_GOOGLE_APP_ID'),
            'client_secret' => env('SOCIALITE_GOOGLE_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => explode(',', env('SOCIALITE_GOOGLE_SCOPES')),
        ],

        /**
         *
         */
        'linkedin'    => [
            'client_id'     => env('SOCIALITE_LINKEDIN_APP_ID'),
            'client_secret' => env('SOCIALITE_LINKEDIN_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => explode(',', env('SOCIALITE_LINKEDIN_SCOPES')),
        ],

        /**
         * Wiki: http://open.weibo.com/wiki/%E6%8E%88%E6%9D%83%E6%9C%BA%E5%88%B6%E8%AF%B4%E6%98%8E
         */
        'weibo'       => [
            'client_id'     => env('SOCIALITE_WEIBO_APP_ID'),
            'client_secret' => env('SOCIALITE_WEIBO_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => explode(',', env('SOCIALITE_WEIBO_SCOPES')),
        ],

        /**
         * Wiki: http://wiki.connect.qq.com/%E7%BD%91%E7%AB%99%E5%BA%94%E7%94%A8%E6%8E%A5%E5%85%A5%E6%B5%81%E7%A8%8B
         */
        'qq'          => [
            'client_id'     => env('SOCIALITE_QQ_APP_ID'),
            'client_secret' => env('SOCIALITE_QQ_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => array_unique(array_merge(
                ['get_user_info'],
                explode(',', env('SOCIALITE_WEIBO_SCOPES'))
            )),
        ],

        /**
         * Wiki: https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140839
         */
        'wechat'      => [
            'client_id'     => env('SOCIALITE_WECHAT_APP_ID'),
            'client_secret' => env('SOCIALITE_WECHAT_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => array_unique(array_merge(
                ['snsapi_base', 'snsapi_userinfo'],
                explode(',', env('SOCIALITE_WEIBO_SCOPES'))
            )),
        ],

        /**
         * Wiki: https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419318590&token=&lang=zh_CN
         */
        'wechat_open' => [
            'client_id'     => env('SOCIALITE_WECHAT_OPEN_APP_ID'),
            'client_secret' => ['your-component-appid', 'your-component-access-token'],
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => ['snsapi_login']
        ],

        /**
         * Wiki:
         */
        'douban'      => [
            'client_id'     => env('SOCIALITE_DOUBAN_OPEN_APP_ID'),
            'client_secret' => env('SOCIALITE_DOUBAN_OPEN_SECRET'),
            'redirect'      => 'socialite/example/callback.php',
            'scopes'        => explode(',', env('SOCIALITE_DOUBAN_SCOPES')),
        ],

    ],

];
