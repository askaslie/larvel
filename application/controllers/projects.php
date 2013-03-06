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

        return( View::make('projects'));
    }

}
