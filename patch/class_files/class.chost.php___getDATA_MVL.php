     public static function getDATA_MVL($options=array()) {
        global $USER_DETAILS;

        $result = array();
        $user_type = $USER_DETAILS['type'];
        $userid = $USER_DETAILS['userid'];

        $def_options = array(
	    'returnHostid' => null,
            'listaHost' => null,
            'userid' => null,
            'busqHOST' => null,
            'busqGROUP' => null,
	    'fijoG' => null,
	    'fijoH' => null,
            'cuentaResultados' => null,
	    'retornaGraficas' => null,
            'hostid' => null,
            'hosts' => null,
	    'filtro' => null,
            'hostGrupos' => null,
	    'hostFiltrados' => null,
	    'gruposFiltrados'=> null,
            'getprofile' => null
        );

        $options = zbx_array_merge($def_options, $options);

        if(!is_null($options['userid'])){
                        $USER_DETAILS['userid']=$options['userid'];
                         $users = CUser::get(array('userids' => $options['userid'],  'extendoutput' => 1));
                                 foreach($users as $unum => $user)
                                        $USER_DETAILS['type']=$user['type'];
                        $user_type = $USER_DETAILS['type'];
                        $userid = $USER_DETAILS['userid'];
        }


        if (!is_null($options['listaHost'])&&(!is_null($options['userid']))) {

           if ( $user_type == 1)
           {
           $sql = 'SELECT h.hostid, h.host, h.ip, g.name, g.groupid FROM hosts h, groups g, hosts_groups hg,'.
           'users_groups ug, rights r WHERE (h.hostid=hg.hostid)and(g.groupid=hg.groupid)and'.
           '(r.groupid=ug.usrgrpid)and(r.id=g.groupid)and(ug.userid='. $options['userid'].')and(r.permission>1)and(h.status=0)and'.
	   '(g.internal<>1)';

                if(!is_null($options['busqHOST'])and(is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host LIKE \'%'.$options['busqHOST'].'%\')';
                }
                if(!is_null($options['busqHOST'])and(!is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host=\''.$options['busqHOST'].'\')';
                }
                if(!is_null($options['busqGROUP'])and(is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name LIKE \'%'.$options['busqGROUP'].'%\')';
                }
                if(!is_null($options['busqGROUP'])and(!is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name =\''.$options['busqGROUP'].'\')';
                }


		$sql = $sql.' ORDER BY g.name';
		$res = DBselect($sql);

	   }
	   else if ( $user_type == 2 ||  $user_type == 3)
           {
           $sql = 'SELECT h.hostid, h.host, h.ip, g.name, g.groupid FROM hosts h, groups g, hosts_groups hg'.
           ' WHERE (h.hostid=hg.hostid)and(g.groupid=hg.groupid)and'.
           '(h.status=0)and(g.internal<>1)';


                if(!is_null($options['busqHOST'])and(is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host LIKE \'%'.$options['busqHOST'].'%\')';
                }
                if(!is_null($options['busqHOST'])and(!is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host=\''.$options['busqHOST'].'\')';
                }
                if(!is_null($options['busqGROUP'])and(is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name LIKE \'%'.$options['busqGROUP'].'%\')';
                }
                if(!is_null($options['busqGROUP'])and(!is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name =\''.$options['busqGROUP'].'\')';
                }

                
                $sql = $sql.' ORDER BY g.name';
		$res = DBselect($sql);

	   }


        $i=0;

        $resultado = array();
        $colum = array();


        while ($colum=DBfetch($res)) {
                	$resultado[$i]= $colum;
                	$i=$i+1;
        }


	}

        // Cuenta host
        if (!is_null($options['cuentaResultados'])&&(!is_null($options['userid']))) {
           if ( $user_type == 1)
           {

             $sql = 'SELECT COUNT(h.hostid) FROM hosts h, groups g, hosts_groups hg,'.
             'users_groups ug, rights r WHERE (h.hostid=hg.hostid)and(g.groupid=hg.groupid)and'.
             '(r.groupid=ug.usrgrpid)and(r.id=g.groupid)and(ug.userid='.  $options['userid']
	      .')and(r.permission>1)and(h.status=0)and'.
	     '(g.internal<>1)';

                if(!is_null($options['busqHOST'])and(is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host LIKE \'%'.$options['busqHOST'].'%\')';
                }
                if(!is_null($options['busqHOST'])and(!is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host=\''.$options['busqHOST'].'\')';
                }
                if(!is_null($options['busqGROUP'])and(is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name LIKE \'%'.$options['busqGROUP'].'%\')';
                }
                if(!is_null($options['busqGROUP'])and(!is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name =\''.$options['busqGROUP'].'\')';
                }
              $sql = $sql.' ORDER BY g.name';
              $res = DBselect($sql);
              


           }
	   else if ($user_type == 2 || $user_type == 3){

	      $sql = 'SELECT COUNT(h.hostid) FROM hosts h, groups g, hosts_groups hg'.
             ' WHERE (h.hostid=hg.hostid)and(g.groupid=hg.groupid)and'.
              '(h.status=0)and'.
             '(g.internal<>1)';

                if(!is_null($options['busqHOST'])and(is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host LIKE \'%'.$options['busqHOST'].'%\')';
                }
                if(!is_null($options['busqHOST'])and(!is_null($options['fijoH']))){
                        $sql = $sql.'and(h.host=\''.$options['busqHOST'].'\')';
                }
                if(!is_null($options['busqGROUP'])and(is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name LIKE \'%'.$options['busqGROUP'].'%\')';
                }
                if(!is_null($options['busqGROUP'])and(!is_null($options['fijoG']))){
                        $sql = $sql.'and(g.name =\''.$options['busqGROUP'].'\')';
                }
                            
              $sql = $sql.' ORDER BY g.name';
	      $res = DBselect($sql);
	   }


        $i=0;
        $resultado = array();
        $colum = array();


        while ($colum=DBfetch($res)) {
                $resultado[$i]= $colum;
                $i=$i+1;
          }
        }


        // Devuelve gráficas
        if (!is_null($options['retornaGraficas'])&&(!is_null($options['hostid']))) {

            $sql = 'SELECT DISTINCT g.graphid, g.name  FROM graphs g, graphs_items gi , items i WHERE '.
            '(g.graphid=gi.graphid)and(gi.itemid=i.itemid)and(i.hostid='.$options['hostid'].')';

            $res = DBselect($sql);
            $i=0;
            $resultado = array();
            $colum = array();
            while ($colum=DBfetch($res)) {
                $resultado[$i]= $colum;
                $i=$i+1;
            }
        }

        if (!is_null($options['getprofile'])&&(!is_null($options['hostid']))) {

             $sql = 'SELECT p.poc_1_name, p.poc_1_email, p.poc_1_phone_1, p.poc_2_name, p.poc_2_email,'.
		    ' p.poc_2_phone_1  FROM hosts_profiles_ext p WHERE (p.hostid='. $options['hostid'] .')';
	    $res = DBselect($sql);
            $i=0;
            $resultado = array();
            $colum = array();
            while ($colum=DBfetch($res)) {
                $resultado[$i]= $colum;
                $i=$i+1;
            }
        }

	// devolve os ids vinculados a un Grupo
        if (!is_null($options['hostGrupos'])) {

             $sql = 'SELECT h.hostid, h.host FROM hosts h, groups g, hosts_groups hg WHERE
(hg.hostid=h.hostid)and(hg.groupid=g.groupid)and(g.groupid='.$options['hostGrupos'].')';
            $res = DBselect($sql);

            $i=0;
            $resultado = array();
            $colum = array();
            while ($colum=DBfetch($res)) {
                $resultado[$i]= $colum;
                $i=$i+1;
            }
        }

	if (!is_null($options['returnHostid'])){
            $sql = "select hostid from hosts where host='".$options['returnHostid']."'";
            $res = DBselect($sql);

            $resultado = array();
            $colum = array();
            $colum=DBfetch($res);
            $resultado['hostid']= $colum;

        }


        COpt::memoryPick();

        // removing keys (hash -> array)
 	//  $resultado = zbx_cleanHashes($resultato);
	
        return $resultado;
}
