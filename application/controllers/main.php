<?php

class Main_Controller extends Base_Controller
{
    public function action_index()
    {
        if ( Auth::check()) {
        } else {
            return Redirect::to('login');
        }
        $type = '';
        $res = '';
        $object_id = trim( Input::Get('object_id'));
        $chain = $this->session_queue( $object_id );

        if( isset( $object_id ) && is_numeric( $object_id )) {
            foreach( array('Rubric', 'Filial', 'Project') as $cl ) {
                $object = $cl::Where('external_id', '=', (string)$object_id )->first();
                if( !empty( $object )) {
                    $raw_entity = Entity::Find( $object->row_entity_id );
                    $res  = json_decode($raw_entity->row_json);
                    $type = $object->rus_name;
                }
            }
        }
        return View::make('homes', array('raw_entity' => $res, 'type' => $type, 'chain' => $chain ));
    }

    private function session_queue( $object_id ) {
        $chain = Session::get( 'chain' );
        if( $object_id ) {
            if ( !$chain ) {
                $chain = array( $object_id );
            } else {
                if( count( $chain) > 4)
                    array_shift( $chain);
                $chain[] = $object_id;
            }
            Session::put( 'chain', $chain );
        }
        return $chain ? $chain : array();
    }
}
