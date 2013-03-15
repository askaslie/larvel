<?php

class Options_Controller extends Base_Controller
{
    public function action_index()
    {
        if ( Auth::check()) {
        } else {
            return Redirect::to('login');
        }
        $options = Audit::first();
        $total_querry_limit = Input::Get( 'total_querry_limit' );
        $api_url    = Input::Get( 'api_url' );
        $api_key    = Input::Get( 'api_key' );
        $api_version = Input::Get( 'api_version' );
        if ( $total_querry_limit && $api_url && $api_key && $api_version ) {
            $options->total_querry_limit = $total_querry_limit < 45000 ? $total_querry_limit :45000;
            $options->api_key = $api_key;
            $options->api_url = $api_url;
            $options->api_version = $api_version;
            $options->save();
        }

        return View::make('options', array(
            'options'         =>  $options,
            'tasks_active'    =>  Parsetask::where('succesfully_parced', '=', false)->count(),
            'total_entries'   =>  Entity::count()
        ));
    }

    public function action_reset() {
        if ( Auth::check()) {
        } else {
            return Redirect::to('login');
        }
        $options = Audit::first();
        $options->total_querry_limit = 40000;
        $options->api_key = 'ruyjie7338';
        $options->api_url = 'http://catalog.api.2gis.ru/';
        $options->api_version = '1.3';
        $options->save();
        return Redirect::to('options');
    }
}
