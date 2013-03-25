<?php

    //проверяет города и филиалы
    class Daemons_Filials_Parser_Controller extends  Daemons_Abstract_Daemon_Controller
    {
        private $name = 'demon_b';

        /**
        *Entry point
        */
        public function action_index()
        {
            header('Content-Type: text/html; charset=utf-8');
            set_time_limit(179);
            if ( $this->check_if_locked( $this->name ))
                echo 'работаем дальше<br>';

            $this->parse_filials();
        }

        /**
         * парсим филиалы
         */
        private function parse_filials()
        {
//            http://catalog.api.2gis.ru/searchinrubric?what=хостинг&where=новосибирск&page=1&pagesize=30&sort=relevance&version=1.3&key=1234567890
            $start = time();
            while( time() - $start < 150 ) {
                $update = false;
                //выбираем таск для обработки/обновления
                $task = Parsetask::where('succesfully_parced', ' = ', false )->first();
                if( empty( $task )) {
                    $check_date = new DateTime();
                    $check_date = $check_date->sub(new DateInterval('P7D'));
                    $task = Parsetask::where('succesfully_parced', ' = ', true )->where( 'updated_at','<', $check_date->format('Y-m-d H:i:s'))->first();
                    $update = true;
                    if( empty( $task )) {
                        echo '<br>Нет заданий для парса!';
                        die();
                    }
                    $task->page = 0;
                }
                $this->lock($this->name);
                $project = Project::where('external_id', '=',$task->project_external_id)->first();
                $rubric  = Rubric::where('external_id', '=',$task->rubric_external_id)->first();
                if( empty( $project ) || empty( $rubric )) {
                    echo '<br>ошибка в задании ', $task->id;
                    die();
                }
                $method = 'searchinrubric';
                while(1) {
                    $params = array(
                        'where'     =>  $project->name,
                        'what'      =>  $rubric->name,
                        'pagesize'  =>  self::PAGESIZE,
                        'page'      =>  $task->page ? $task->page : 1,
                        'sort'      =>  'relevance'
                    );
                    $res = json_decode( $this->api_query( $method, $params ));
                    if( isset( $res->error_message )) {
                        if( $res->response_code == 400) {
                            $task->succesfully_parced = true;
                            $task->save();
                            break;
                        }
                        //todo errorhandler
                    }

                    foreach( $res->result as $filial_jr ) {
                        //Пропускаем уже спарсенное
                        $check = Filial::where( 'external_id', '=', $filial_jr->id )->first();
                        if( !empty( $check ) && !$update ) {
                            continue;
                        }
                        if( !$this->get_filial( $filial_jr->id, $filial_jr->hash, $project->external_id, $task->id, $check ))
                            continue;
                        $check = Firm::where( 'external_id', '=', $filial_jr->firm_group->id )->get();
                        if( !empty( $check ))
                            continue;
                        $this->get_firm($filial_jr->firm_group->id);
                    }
                    $task->page ++;
                    $task->filials_count = $res->total;
                    $task->save();
                }
                print_r($this->querry_counter);
                $this->audit->querry_count = $this->querry_counter;
                $this->audit->save();
            }
        }

        private function get_filial( $id, $hash, $project_id, $task_id, $filial = null )
        {
            $method = 'profile';
            $params = array(
                'id'     =>  $id,
                'hash'   =>  $hash,
            );
            $raw_res = $this->api_query( $method, $params );
            $res = json_decode($raw_res);
            unset($res->see_also);
            $raw_res = json_encode( $res );
            if ( isset( $res->error_message )) {
                //todo логи
                print_r( $res );
               return false;
            }
            if ( isset( $res->title ))
                return true;

            if( !$filial ) {
                $raw_entity_id = $this->create_entity( Entity::ENTITY_FILIAL, $raw_res );
                $filial = new Filial( array(
                    'external_id'       =>  $res->id,
                    'firm_external_id'  =>  $res->firm_group->id,
                    'project_id'        =>  $project_id,
                    'name'              =>  $res->name,
                    'row_entity_id'     =>  $raw_entity_id,
                    'parsetask_id'      =>  $task_id
                ));
            } else {
                $raw_entity = Entity::Find( $filial->row_entity_id );
                $raw_entity->row_json = $raw_res;
                $filial->name = $res->name;
                $filial->external_id = $res->id;
                $filial->parsetask_id = $task_id;
                $raw_entity->save();
            }
            $filial->save();
        }

        private function get_firm( $id )
        {
            $method = 'firmsByFilialId';
            $params = array(
                'firmid'     =>  $id,
                'pagesize'   =>  self::PAGESIZE,
            );
            $raw_res = $this->api_query( $method, $params );
            $res = json_decode($raw_res);
            if ( isset( $res->error_message )) {
                //todo логи
                print_r( $res );
                return false;
            }
            if ( isset( $res->title ))
                return true;
            $raw_entity_id = $this->create_entity( Entity::ENTITY_FIRM, $raw_res );
            $firm = new Firm( array(
                'external_id'       =>  $res->firm_id,
                'row_entity_id'     =>  $raw_entity_id
            ));
            $firm->save();
        }
    }