<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mr. White
 * Date: 27.02.13
 * Time: 2:22
 * To change this template use File | Settings | File Templates.
 */
class Task_Controller extends Base_Controller
{
    public function action_index()
    {
        if ( Auth::check() ) {
        } else {
            return Redirect::to('login');
        }
        $task_id = Input::Get( 'taskId' );
        $result = array();
        if ( $task_id ) {
            $task = Parsetask::get( $task_id );
            if( $task ) {
                $project_id = trim( Input::Get('project_id'));
            }
        }
        return View::make('projects', array(
            'projects'      =>  $projects,
            'subrubrics'    =>  $res_subrubrics,
            'rubrics'       =>  $res_rubrics,
            'current_project_id' => $project_id,
        ));
    }

}
