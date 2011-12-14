	public static function action_MVL($options=array()) {
        global $USER_DETAILS;

        $result = array();
        $user_type = $USER_DETAILS['type'];
        $userid = $USER_DETAILS['userid'];

        $def_options = array(
            'status' => null,	public static function action_MVL($options=array()) {
        global $USER_DETAILS;

        $result = array();
        $user_type = $USER_DETAILS['type'];
        $userid = $USER_DETAILS['userid'];

        $def_options = array(
            'status' => null,
            'enable' => null,
            'hostid' => null
        );

        $options = zbx_array_merge($def_options, $options);
        
        if(!is_null($options['status'])&&
                (!is_null($options['hostid']))){
                $sql="select actionid from conditions where actionid in (36) and conditiontype=1 and operator=1 and value='".$options['hostid']."'";

            $res = DBselect($sql);
            $resultado = array();
            $colum = array();


            $colum = DBfetch($res);
            if ($colum>0) {
                $resultado['status']="Desactivado";
            } else {
                $resultado['status']="Activado";
            }
                

        } 
        else if (!is_null($options['enable'])&&
                (!is_null($options['hostid']))){


                if($options['enable']=="false"){

                $conditionid = get_dbid("conditions","conditionid");

                $sql="insert into conditions (conditionid,actionid,conditiontype,operator,value) values (".$conditionid.",36,1,1,'".$options['hostid']."')";
                DBexecute($sql);

                } else if ($options['enable']=="true"){

                $sql="delete from conditions where actionid in (36) and conditiontype=1 and operator=1 and value='".$options['hostid']."'";

                DBexecute($sql);

                }


        }

    COpt::memoryPick();

    // removing keys (hash -> array)
    //       $resultado = zbx_cleanHashes($resultato);

    return $resultado;
	}
            'enable' => null,
            'hostid' => null
        );

        $options = zbx_array_merge($def_options, $options);
        
        if(!is_null($options['status'])&&
                (!is_null($options['hostid']))){
                $sql="select actionid from conditions where actionid in (36) and conditiontype=1 and operator=1 and value='".$options['hostid']."'";

            $res = DBselect($sql);
            $resultado = array();
            $colum = array();


            $colum = DBfetch($res);
            if ($colum>0) {
                $resultado['status']="Desactivado";
            } else {
                $resultado['status']="Activado";
            }
                

        } 
        else if (!is_null($options['enable'])&&
                (!is_null($options['hostid']))){


                if($options['enable']=="false"){

                $conditionid = get_dbid("conditions","conditionid");

                $sql="insert into conditions (conditionid,actionid,conditiontype,operator,value) values (".$conditionid.",36,1,1,'".$options['hostid']."')";
                DBexecute($sql);

                } else if ($options['enable']=="true"){

                $sql="delete from conditions where actionid in (36) and conditiontype=1 and operator=1 and value='".$options['hostid']."'";

                DBexecute($sql);

                }


        }

    COpt::memoryPick();

    // removing keys (hash -> array)
    //       $resultado = zbx_cleanHashes($resultato);

    return $resultado;
	}
