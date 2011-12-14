
	public static function event_MVL($options=array()) {
        global $USER_DETAILS;

        $result = array();
        $user_type = $USER_DETAILS['type'];
        $userid = $USER_DETAILS['userid'];

        $def_options = array(
            'clock' => null,
            'triggerid' => null
        );

        if(!is_null($options['clock'])&&
                (!is_null($options['triggerid']))){

        $sql = "select * from events where (objectid=".$options['triggerid'].")&&(clock=".
                        $options['clock'].")";
            
        $res = DBselect($sql);
        $i=0;

        $resultado = array();
        $colum = array();



        while ($colum=DBfetch($res)) {
                        $resultado[$i]= $colum;
                        $i=$i+1;
        }


        } 

    COpt::memoryPick();

    // removing keys (hash -> array)
    //       $resultado = zbx_cleanHashes($resultato);

    return $resultado;
}
