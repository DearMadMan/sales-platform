<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2015/6/13
 * Time: 15:09
 */

return [
    'domain' => 'http://ddd.tunnel.mobi/',
    'storage_path' => "uploads/",
    'compress_rate' => 90,   //压缩比率
    'compress_cover' => true,  //压缩后覆盖原文件
    'compress_config_enable' => true,
    'compress_config' => [
        'thumb' => [
            'width' => 100,
            'height' => 100
        ],
        'img' => [
            'width' => 300,
            'height' => 300
        ]
    ]
];