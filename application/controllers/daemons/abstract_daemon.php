<?php

class Daemons_Abstract_Daemon_Controller extends Controller
{
    /**
    *Entry point
    */
    protected $audit;
    protected $querry_limit;
    protected $api_url;
    protected $key;
    protected $vers;
    protected $querry_counter;
    const PAGESIZE = 50;

    public function __construct()
    {
        $this->audit = Audit::first();
        $this->querry_limit = Config::get('daemons.total_querry_limit');

        if( empty( $this->audit )) {
            $now = new DateTime();
            $set = $now->sub( new DateInterval('P1D'));
            $this->audit = new Audit( array(
                'querry_count'     =>  0,
                'demon_a_activity' =>  $set,
                'demon_b_activity' =>  $set,
                'demon_c_activity' =>  $set,
                'querry_count_reset_time' => $now
            ));
            $this->audit->save();
        }
        $this->api_url = Config::get('daemons.api_url');
        $this->key = Config::get('daemons.api_key');
        $this->vers = Config::get('daemons.api_version');
        $this->querry_counter = $this->audit->querry_count;
        if( $this->audit->querry_count > $this->querry_limit )
            die('На сегодня лимит запросов исчерпан!');
        echo 'работаем<br>';
    }

    protected function check_if_locked( $daemon_name )
    {
        $daemon_name_act = $daemon_name . '_activity';
        $last_act = new DateTime( $this->audit->$daemon_name_act );
        $now = new DateTime();
        $interval = $now->diff( $last_act );
        $total_diff = $interval->s + $interval->i * 60 + $interval->h * 60 * 60 + $interval->d * 60 * 60 * 24;
        if ( $total_diff < Config::get('daemons.' . $daemon_name . '_interval'))
            die('К сожалению, демон ' . $daemon_name . ' временно не доступен. ');
        return true;
    }

    protected function lock( $daemon_name )
    {
        $daemon_name_act = $daemon_name . '_activity';
        $this->audit->$daemon_name_act = new DateTime();
        $this->audit->save();
    }

    public function api_query( $method, $params = array())
    {
        $this->querry_counter ++;
        $params['key'] = $this->key;
        $params['version'] = $this->vers;
        $params = '?' . http_build_query( $params );
        $url = $this->api_url . $method . $params;
        echo '<br>' . $url . '<br>';
        sleep(0.2);
        return $this->qurl_request( $url );
    }

    public function qurl_request( $url, $headers = '', $uagent = '' )
    {
        if (empty( $url )) {
            return false;
        }
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT , 180 );

        if (is_array( $headers )) { // РµСЃР»Рё Р·Р°РґР°РЅС‹ РєР°РєРёРµ-С‚Рѕ Р·Р°РіРѕР»РѕРІРєРё РґР»СЏ Р±СЂР°СѓР·РµСЂР°
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (!empty($uagent)) { // РµСЃР»Рё Р·Р°РґР°РЅ UserAgent
            curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
        } else{
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1)');
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            //todo логи
            echo "<br>error in curl: ". curl_error($ch) ."<br>";
            return false;
        }

        curl_close($ch);
        return $result;
    }

    protected function create_entity( $entity_name, $json )
    {
        $entity = new Entity( array(
            'entity_name'           =>  $entity_name,
            'row_json'              =>  $json
        ));
        $entity->timestamps();
        $entity->save();
        return $entity->id;
    }


}