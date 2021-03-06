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
            foreach( array('Rubric', 'Filial', 'Project', 'Firm') as $cl ) {
                $object = $cl::Where('external_id', '=', (string)$object_id )->first();
                if( !empty( $object )) {
                    $raw_entity = Entity::Find( $object->row_entity_id );
                    $res  = json_decode($raw_entity->row_json);
                    $type = $object->rus_name;
                }
            }
        } elseif( $object_id == 'random') {
            $raw_entity = Entity::where_entity_name(3)->order_by(DB::raw(''),DB::raw('RAND()'))->first();
            if( $raw_entity ) {
                $res  = json_decode($raw_entity->row_json);
                $type = 'филиал';
            }
        }
        return View::make('homes', array('raw_entity' => $res, 'type' => $type, 'chain' => $chain ));
    }

    private function session_queue( $object_id ) {
//        $chain = Session::get( 'chain' );
        $entitys = DB::table('row_entitys')->order_by('id','desc')->take(5)->get();
        $chain = array();
        foreach( $entitys as $a ){
            $b = json_decode( $a->row_json);
            $chain[] = isset( $b->id) ? $b->id : $b->firm_id;
        }

        Session::put( 'chain', $chain );
        return $chain ? $chain : array();
    }
}
