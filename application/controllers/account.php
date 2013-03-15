<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mr. White
 * Date: 27.02.13
 * Time: 2:22
 * To change this template use File | Settings | File Templates.
 */
class Account_Controller extends Base_Controller
{
    public function action_index()
    {
        $users = DB::query('delete  from filials');
        $users = DB::query('delete  from tasks');
        $users = DB::query('delete  from row_entitys where entity_name = 3');
    }
    public function action_logisdsdsn()
    {
        Schema::create('firms', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->integer('row_entity_id');
            $table->timestamps();
        });

        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('username', 128);
            $table->string('password', 64);
        });

        Schema::create('tasks', function($table) {
            $table->increments('id');
            $table->string('project_external_id');
            $table->string('rubric_external_id');
            $table->boolean('succesfully_parced');
            $table->integer('filials_count');
            $table->integer('page');
            $table->timestamps('');
        });

        Schema::create('daemons', function($table) {
            $table->increments('id');
            $table->integer('querry_count');
            $table->timestamp('demon_a_activity');
            $table->timestamp('demon_b_activity');
            $table->timestamp('demon_c_activity');
            $table->timestamp('querry_count_reset_time');
            $table->integer('total_querry_limit' );
            $table->string('api_url');
            $table->string('api_key' );
            $table->string('api_version');
        });
        Schema::create('row_entitys', function($table) {
            $table->increments('id');
            $table->integer('entity_name');
            $table->text('row_json');
            $table->timestamps();
        });
        Schema::create('filials', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('firm_external_id', 32);
            $table->string('project_id', 32);
            $table->string('name', 150);
            $table->integer('row_entity_id');
            $table->timestamps();
        });
        Schema::create('rubrics', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('parent_rubric_external_id', 32);
            $table->string('name', 150);
            $table->string('project_external_id', 20);
            $table->integer('row_entity_id');
        });
        Schema::create('projects', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('name', 150);
            $table->integer('row_entity_id');
            $table->boolean('succesfully_parced');
        });
        $pass = Hash::make('my_password_string');
        User::insert( array( 'username' =>  'admin',
            'password' =>  $pass
        ));
        $now = new DateTime();
        $set = $now->sub( new DateInterval('P1D'));
        $audit = new Audit( array(
            'querry_count'     =>  0,
            'demon_a_activity' =>  $set,
            'demon_b_activity' =>  $set,
            'demon_c_activity' =>  $set,
            'querry_count_reset_time' => $now,
            'total_querry_limit'    =>  1000,
            'demon_a_interval'      =>  86300,
            'demon_b_interval'      =>  298,
            'api_url'               =>  'http://catalog.api.2gis.ru/',
            'api_key'               =>  'ruyjie7338',
            'api_version'           =>  '1.3',
        ));
    }

}
