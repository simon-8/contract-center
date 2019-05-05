<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('oauth_clients')->delete();
        
        \DB::table('oauth_clients')->insert(array (
            0 => 
            array (
                'id' => 11,
                'user_id' => NULL,
                'name' => '连线机',
                'secret' => '69LGGRc9ZjWbSa0Ipgzdet5ZfWC94tqbIHv60wOq',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2018-07-21 01:19:51',
                'updated_at' => '2018-07-21 01:19:51',
                'notify' => 'http://192.168.2.180:2002',
                'coin' => 0,
                'sync_login' => 0,
            ),
        ));
        
        
    }
}