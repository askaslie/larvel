<?php

    //проверяет города и филиалы
    class Daemons_Parser_Processer_Controller extends  Daemons_Abstract_Daemon_Controller
    {
        private $name = 'demon_a';

        /**
        *Entry point
        */
        public function action_index()
        {
            if ( $this->check_if_locked( $this->name ))
                echo 'работаем дальше<br>';

            $this->parse_projects();


            $this->lock( $this->name );
        }

        private function parse_projects()
        {
            $method = 'project/list';
            $res = json_decode( $this->api_query( $method ));
            if( isset( $res->error_message )) {
                //todo errorhandler
            }

            foreach( $res->result as $project_obj ) {
                $check  = Project::where('external_id', '=', $project_obj->id )->get();
                if ( !empty( $check )) {
                    echo '<br>';
                    //todo проверка на изменения?
                    echo $project_obj->id, ' уже есть в базе! <br>';
                    continue;
                }

                $entity = new Entity( array(
                        'entity_external_id'    =>  $project_obj->id,
                        'entity_name'           =>  Entity::ENTITY_PROJECT,
                        'row_json'              =>  json_encode( $project_obj )
                ));
                $entity->timestamps();
                $entity->save();
                if (isset( $entity->id)) {
                    $project = new Project( array(
                        'external_id'   =>  $project_obj->id,
                        'row_entity_id' =>  $entity->id,
                        'name'          =>  $project_obj->name,
                    ));
                    $project->save();
                }
            }
        }
    }
