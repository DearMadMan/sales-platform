<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TableInitSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* 用户类型 */
        DB::table('user_types')->insert([
            [
                'type_name' => '粉丝'
            ],
            [
                'type_name' => '管理员'
            ],
            [
                'type_name' => '公共号'
            ],
        ]);

        /* 测试会员 */
        DB::table('users')->insert([
            [
                'user_type_id' => '3',
                'name' => 'wang',
                'email' => 'i@dearmadman.com',
                'password' => Hash::make('wang'),
                'nick_name' => 'wang',
                'manager_id' => 1
            ],
            [
                'user_type_id' => '3',
                'name' => 'wang',
                'email' => 'test@qq.com',
                'password' => Hash::make('wang'),
                'nick_name' => 'wang',
                'manager_id' => 1
            ],
        ]);

        /* 测试管理帐号 */
        DB::table('wechat_managers')->insert([
                [
                    'name' => 'wang',
                    'user_id' => 1,
                    'wechat' => 'wang',
                    'phone' => '18949825256',
                    'email' => '2034906607@qq.com',
                    'qq' => '2034906607',
                ],
                [
                    'name' => 'wang',
                    'user_id' => 2,
                    'wechat' => 'test',
                    'phone' => '18949825256',
                    'email' => 'test@qq.com',
                    'qq' => '2034906607',
                ]
            ]
        );

        /* 配置Key */
        DB::table('wechat_config_keys')->insert([
                [
                    'key' => 'token',
                    'default_value' => ''
                ],
                [
                    'key' => 'app_id',
                    'default_value' => ''
                ],
                [
                    'key' => 'app_secret',
                    'default_value' => ''
                ],
                [
                    'key' => 'encodingAESKey',
                    'default_value' => ''
                ],
                [
                    'key' => 'subscribe',
                    'default_value' => '0'
                ]
            ]
        );


        DB::table('wechat_configs')->insert([
                [

                    'manager_id' => 1,
                    'configs' => '{"token":"wang","app_id":"wx51bbebf779eec25f","app_secret":"1f8bcc3a5f0dd9bcf62ee6b4a16d4b6f"}'
                ]
            ]
        );

    }


}

