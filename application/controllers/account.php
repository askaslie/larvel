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
            $table->string('entity_name', 10);
            $table->string('entity_external_id', 32);
            $table->text('row_json');
            $table->timestamps();
        });
        Schema::create('filials', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('firm_external_id', 32);
            $table->string('city_id', 32);
            $table->string('name', 150);
        });
        Schema::create('rubrics', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('parent_rubric_external_id', 32);
            $table->string('name', 150);
        });
        Schema::create('projects', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('name', 150);
            $table->integer('row_entity_id');
        });
    }
    public function action_logisdsdsn()
    {
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
            $table->string('entity_name', 10);
            $table->string('entity_external_id', 32);
            $table->text('row_json');
            $table->timestamps();
        });
        Schema::create('filials', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('firm_external_id', 32);
            $table->string('city_id', 32);
            $table->string('name', 150);
        });
        Schema::create('rubrics', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('parent_rubric_external_id', 32);
            $table->string('name', 150);
        });
        Schema::create('projects', function($table) {
            $table->increments('id');
            $table->string('external_id', 32);
            $table->string('name', 150);
            $table->row_entity_id('int');
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
