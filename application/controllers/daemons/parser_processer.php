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
            set_time_limit(2000);
            if ( $this->check_if_locked( $this->name ))
                echo 'работаем дальше<br>';

            $this->parse_projects();
            while(1 ) {
                if( !$this->parse_rubrics())
                    break;
                sleep(7);
            }
            $this->lock( $this->name );
        }

        /**
         * парсим список проектов, 1 запрос
         */
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

                $id = $this->create_entity( Entity::ENTITY_PROJECT,  json_encode( $project_obj));
                if (isset( $id)) {
                    $project = new Project( array(
                        'external_id'   =>  $project_obj->id,
                        'row_entity_id' =>  $id,
                        'name'          =>  $project_obj->name,
                        'succesfully_parced' => false
                    ));
                    $project->save();
                }
            }
        }

        private function parse_rubrics()
        {
            $st = microtime(1);
            $project = Project::where('succesfully_parced', ' = ', false )->first();
            print_r( $project);
            if( empty( $project ))
                return false;
            $params = array(
                'where'         =>  $project->name,
                'show_children' =>  1
            );
            $res = json_decode( $this->api_query( 'rubricator', $params ));

            $rubric = array();
            $entitys = array();
            $first_inserted_id = 0;
            foreach( $res->result as $rub ) {
                //сохраняем подрубрики
                foreach( $rub->children as $subrub ) {
                    if ( $this->check_rubric_exsits( $project->external_id, $subrub->id )) {
                        $entitys[] = array(
                                        'entity_name'           =>  Entity::ENTITY_RUBRIC,
                                        'row_json'              =>  json_encode( $subrub )
                                    );
                        $rubric[] =   array(
                            'row_entity_id' =>  0,
                            'external_id'   =>  $subrub->id,
                            'name'          =>  $subrub->name,
                            'parent_rubric_external_id' =>  $rub->id,
                            'project_external_id'       =>  $project->external_id,
                        );
                    }
                }

                unset($rub->children);
                if ( $this->check_rubric_exsits( $project->external_id, $rub->id )) {
                    $entitys[] = array(
                        'entity_name'           =>  Entity::ENTITY_RUBRIC,
                        'row_json'              =>  json_encode( $rub )
                    );
                    $rubric[] = array(
                        'row_entity_id' =>  0,
                        'external_id'   =>  $rub->id,
                        'name'          =>  $rub->name,
                        'parent_rubric_external_id' =>  '0',
                        'project_external_id'       =>  $project->external_id,
                    );
                }
            }
            if ( count( $entitys ) != count( $rubric ))
                echo 'fuck!!';

            $ent_chunks = array_chunk( $entitys, 200);
            foreach( $ent_chunks as $chunk ) {
                $res  = Entity::insert_get_id( $chunk );

                if ( !$first_inserted_id )
                    $first_inserted_id = $res;
            }
            foreach( $rubric as &$rub ) {
                $rub['row_entity_id'] = $first_inserted_id ++;
            }
            Rubric::insert( $rubric );
            unset( $rub );
            unset( $rubric );
            unset( $entitys );
            $project->succesfully_parced = true;
            $project->save();
            return true;

        }

        private function check_rubric_exsits( $proj_id, $rubric_id )
        {
            $check = Rubric::where( 'project_external_id', '=', $proj_id )->where( 'external_id','=', $rubric_id )->get();
            return empty($check);
        }



    }
