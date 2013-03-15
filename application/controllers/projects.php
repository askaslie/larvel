<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mr. White
 * Date: 27.02.13
 * Time: 2:22
 * To change this template use File | Settings | File Templates.
 */
class Projects_Controller extends Base_Controller
{
    public function action_index()
    {
        if ( Auth::check() ) {
        } else {
            return Redirect::to('login');
        }
        $arr = Input::Get( 'arr' );
        $project_id = trim( Input::Get('project_id'));
        $project_id = $project_id ? $project_id : 69;

        if( is_array( $arr ) && !empty( $arr) && is_numeric( $project_id )) {
            foreach( $arr as $rubric_id ) {
                $check = Parsetask::where('project_external_id', '=', $project_id )->
                    where('rubric_external_id', '=', $rubric_id)->get();
                if( !empty( $check )) {
                    continue;
                }
                $task = new Parsetask( array(
                    'project_external_id'   =>  $project_id,
                    'rubric_external_id'    =>  $rubric_id,
                    'succesfully_parced'    =>  false,
                    'filials_count'         =>  0,
                    'page'                  =>  1,
                ));
                $task->Save();
            }

        }

        $res_rubrics    = array();
        $res_subrubrics = array();
        if( $project_id  && is_numeric( $project_id )) {
            $tasks = Parsetask::Where('project_external_id', '=', $project_id )->get();
            $task_status_array = array();
            foreach( $tasks as $task ) {
                $task_status_array[$task->rubric_external_id] = $task->succesfully_parced;
            }
            $rubrics = Rubric::Where('project_external_id', '=', $project_id )->get();
            foreach( $rubrics as $rubric ) {
                if( $rubric->parent_rubric_external_id == 0 ) {
                    $res_rubrics[$rubric->external_id] = $rubric->name;
                } else {
                    $status = isset($task_status_array[$rubric->external_id]) ?
                        $task_status_array[$rubric->external_id] ? ' (done)' : ' (in process)' : '';
                    $res_subrubrics[$rubric->parent_rubric_external_id][] = array(
                        'external_id' =>    $rubric->external_id,
                        'name'        =>    $rubric->name,
                        'status'      =>    $status
                    );
                }
            }

        }
        $projects = Project::Get();

        return View::make('projects', array(
            'projects'      =>  $projects,
            'subrubrics'    =>  $res_subrubrics,
            'rubrics'       =>  $res_rubrics,
            'current_project_id' => $project_id,
        ));
    }

}
