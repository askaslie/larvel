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
        if ( $task_id ) {
            $task = Parsetask::where( 'id', '=', $task_id )->get();
            if( $task ) {
                $filials = Filial::where('parsetask_id','=', $task_id)->get();
                foreach( $filials as $filial ) {
                    $entity = ( Entity::where('id', '=', $filial->row_entity_id)->first());
                    $filial->info = json_decode( $entity->row_json);
                    }
            }
        }
        return View::make('tasks', array(
            'filials'   =>  $filials
        ));
    }

}
