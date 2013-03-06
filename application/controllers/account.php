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
//        if (Auth::check())
//        {
//            return "You're logged in!";
//        } else {
//            return Redirect::to('login');
//        }
        $object = Rubric::Where('external_id', '=', '8022157095337992' )->first();
        print_r($object);
        echo URL::to_asset('css/style.css');
        $password = Hash::make('5@ch0k');
        print_r($password);
        Asset::add('jquery', 'js/jquery.js');
    }
    public function action_logisdsdsn()
    {        Schema::create('users', function($table) {
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
            $table->integer('row_entity_id');
            $table->string('name', 150);
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
    }
    public function action_logout()
    {
        echo "This is the logout action.";
    }
    public function action_welcome($name = 'username')
    {
        $array_test = array(1,2,3,4);
        return View::make('welcome')->
            with('test', $array_test);
    }
}
