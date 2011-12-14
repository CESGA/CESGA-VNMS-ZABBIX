	// getDATA_MVL
public static function getDATA_MVL($options=array()) {
        global $USER_DETAILS;

        $result = array();
        $user_type = $USER_DETAILS['type'];
        $userid = $USER_DETAILS['userid'];

        $def_options = array(
	    'userid' => null,
	    'eventid' => null,
	    'ack' => null,
	    'time' => null,
            'infoHost' => null,
            'infoTrigger' => null,
            'idHost' => null,
            'numTriggers' => null,
	    'infoTriggersActivos' => null
        );

        $options = zbx_array_merge($def_options, $options);
	
	if(!is_null($options['eventid'])&&(!is_null($options['eventid']))&&
		(!is_null($options['ack']))&&(!is_null($options['time']))){


		$acknowledgeid = get_dbid("acknowledges","acknowledgeid");

                $sql = 'INSERT INTO acknowledges(acknowledgeid,userid,eventid,clock,message) VALUES(
                        '.$acknowledgeid.','.$options['userid'].','.$options['eventid'].','.$options['time'].',"OK")';
                DBexecute($sql);
                $sql= 'UPDATE events SET acknowledged=1 WHERE (eventid='. $options['eventid'] .')';
                DBexecute($sql);

        }
	else if (!is_null($options['infoHost'])) {
       	     $sql='SELECT DISTINCT h.hostid, h.host, g.name, h.ip, t.triggerid, t.priority, ev.eventid, ev.clock  FROM   triggers t,(SELECT  objectid,
	max(eventid) as eventid, max(clock) as clock FROM events WHERE (value=1) GROUP BY objectid) ev, hosts h, groups g, hosts_groups hg, users_groups ug,
	rights r, items it, functions f WHERE  (t.status=0) and(t.value=1)and(t.triggerid=ev.objectid)and (h.hostid=it.hostid)and (it.itemid=f.itemid)and
	(f.triggerid=t.triggerid)and(g.groupid=hg.groupid)and(r.groupid=ug.usrgrpid)and(r.id=g.groupid)and(ug.userid='.
	$options['userid'].')and(r.permission>1)and(h.hostid=hg.hostid)and(g.name NOT LIKE "^%")and(g.internal<>1)and
	(g.name<>"Imported hosts")   group by h.host order by g.name DESC';

            $res = DBselect($sql);
            $i = 0;
            $resultado = array();
            $colum = array();

            while ($colum = DBfetch($res)) {
                $sql='SELECT acknowledged FROM events WHERE (eventid='. $colum[eventid].')';
                $res2 = DBselect($sql);
                $col2 = DBfetch($res2);
                $colum[acknowledged]=$col2['acknowledged'];
                $resultado[$i] = $colum;
                $i = $i + 1;
            }


        }

        else if (!is_null($options['infoTrigger']) && !is_null($options['idHost'])) {
            $sql = 'SELECT t.description, t.status, t.priority, t.triggerid, t.value   FROM triggers t,'.
                'functions f, items it WHERE (t.triggerid=f.triggerid)&&(it.itemid=f.itemid)&&(it.hostid='.
                $options['idHost'].') ORDER BY t.value DESC';

              

            $res = DBselect($sql);
            $i = 0;
            $resultado = array();
            $colum = array();


            while ($colum = DBfetch($res)) {
                $resultado[$i] = $colum;
                $i = $i + 1;
            }
        }
            else if (!is_null($options['infoTriggersActivos'])&&(!is_null($options['idHost']))) {
           $sql = 'SELECT DISTINCT ev.eventid,ev.clock,ev.value "valorEvento",max(ev.clock) "timeEvento"'.
            ',t.triggerid,t.description, t.value, t.status, t.priority FROM hosts h, triggers t, items it,'.
            'functions f, events ev WHERE(h.hostid=it.hostid)and(it.itemid=f.itemid)and(f.triggerid=t.triggerid)'.
            'and(t.status=0)and(t.value=1)and(ev.objectid=t.triggerid) and(ev.value=1)and(h.hostid='.
            $options['idHost'].') group by t.triggerid order by t.priority DESC limit 10;'; 


            $res = DBselect($sql);
            $i = 0;
            $resultado = array();
            $colum = array();


            while ($colum = DBfetch($res)) {
                $resultado[$i] = $colum;
                $i = $i + 1;
            }


        }

    COpt::memoryPick();

    // removing keys (hash -> array)
    //       $resultado = zbx_cleanHashes($resultato);

    return $resultado;
}
