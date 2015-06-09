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
        public function run ()
        {


            DB::table ('user_types')->insert ([
                [
                    'type_name' => '粉丝'
                ] ,
                [
                    'type_name' => '管理员'
                ] ,
                [
                    'type_name' => '公共号'
                ] ,
            ]);

            DB::table ('users')->insert ([
                [
                    'user_type_id' => '2' ,
                    'name'         => 'wang' ,
                    'email'        => '2034906607@qq.com' ,
                    'password'     => Hash::make ('wang') ,
                    'nick_name'    => 'wang',
                    'manager_id'   => 1
                ] ,
                [
                    'user_type_id' => '3' ,
                    'name'         => 'wang' ,
                    'email'        => 'test@qq.com' ,
                    'password'     => Hash::make ('wang') ,
                    'nick_name'    => 'wang',
                    'manager_id'   => 1
                ] ,
            ]);

            DB::table('wechat_managers')->insert(
                [
                 'name'=>'wang',
                 'user_id'=>2,
                 'wechat'=>'',
                 'phone'=>'18949825256',
                 'email'=>'2034906607@qq.com',
                 'qq'=>'2034906607',
                ]
            );


        }


    }

