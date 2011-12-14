<?php

php?>

<?php


global  $SERVER_ZABBIX;
        $SERVER_ZABBIX = " URL of HOST ";
global  $USER_API_ZABBIX;
        $USER_API_ZABBIX= " zabbix user with access API ";
global  $PASS_API_ZABBIX;
        $PASS_API_ZABBIX= " pass for zabbix user api";
global  $USER_READ_ONLY_ZABBIX;
        $USER_READ_ONLY_ZABBIX=
               " one zabbix user with only read permissions ";
global  $PASS_READ_ONLY_ZABBIX;
        $PASS_READ_ONLY_ZABBIX=
               " one user with only read permissions";

/* If this varible is true, we use LDAP identification */
global  $LOGIN_WITH_LDAP;
        $LOGIN_WITH_LDAP = false;
global  $LDAP_SERVER;
        $LDAP_SERVER = " server LDAP ";
global  $LDAP_SEARCH_DN;
        $LDAP_SEARCH_DN=" DN of LDAP ";

global  $LDAP_BIND_USER;
        $LDAP_BIND_USER = " BIND user for LDAP";
global  $LDAP_BIN_PASS;
        $LDAP_BIN_PASS = " Pass for BIND ";

/* Check if user contains one atributte that it defines the
 *  permissions to access zabbix*/

global $LDAP_USE_PERMISSION_ATRIBUTE;
       $LDAP_USE_PERMISSION_ATRIBUTE = true;

global $LDAP_PERMISSION_ATRIBUTE;
       $LDAP_PERMISSION_ATRIBUTE =
                        " tag name for permission atribute";


/* The aplication must have permissions in this directory*/
global  $DIR_TEMP;
        $DIR_TEMP=" temporal directory ";



php?>
