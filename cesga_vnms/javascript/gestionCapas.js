/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function visibilidadFiltro2(){
    var select = document.getElementById("filtroF");
    var i = select.selectedIndex;
    var valor = select.options[i].value;
    var elementos =document.getElementsByName("filtraHost");
    for (i=0;i<elementos.length;i++){
        elementos[i].style.display = "none";
    }
    document.getElementById(valor).style.display= "block";

}

function visibilidadFiltro(){
    var select = document.getElementById("filtroF");
    var i = select.selectedIndex;
    var valor = select.options[i].value;
    var elementos =document.getElementsByName("filtraHost");
    for (i=0;i<elementos.length;i++){
        elementos[i].style.display = "none";
    }
    document.getElementById(valor).style.display= "block";

}


function retornaURL(){
    return location.URL;
}


var fullscreen = false;

function fulls_creen(name,id,a,b,c){
    
    var idF = document.getElementById("idgrafF");
    idF.value= id;
    fullscreen = true;
    genera_grafica(id,a,b,c);
    document.getElementById("tituloSeccionGrafF").value = name;
}

function fulls_creen2(a,b,c){
    var idF = document.getElementById("idgrafF").value;
    fullscreen = true;
    genera_grafica(idF,a,b,c);

}



var id1;
var req1;
var isIE1 = false;
// hostid
// host
// ip
// grupo
function  genera_grafica(id,alt,anch,per) {

    id1 = id;
    var url = "controlador.php?graficaDinamica=1"
        +"&g_Dinamica="+ id 
        +"&anch_Dinamica="+ anch
        +"&alt_Dinamica="+ alt
        +"&per_Dinamica="+ per;
    
    //  Usuario inteligente...
    if (window.XMLHttpRequest) {
        req1 = new XMLHttpRequest();
        req1.onreadystatechange = processReqChange;
        req1.open("GET", url, true);
        req1.send(null);
    //  ...y usuario de Internet Explorer Windows
    } else if (window.ActiveXObject) {
        isIE = true;
        req1 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req1) {
            req1.onreadystatechange = processReqChange;
            req1.open("GET", url, true);
            req1.send();
        }
    }
}

function processReqChange(){

    if(req1.readyState == 4){
        var resultado = req1.responseText;
        if (fullscreen == false ) {
            //document.getElementById("graf"+id1).src="data:image/png;base64," + resultado;
            document.getElementById("graf"+id1).src= resultado;
        } else {
            //document.getElementById("imagenFullGraf").src="data:image/png;base64,"+resultado;
            document.getElementById("imagenFullGraf").src=resultado;
        }
        fullscreen = false;

    }
}



 function buscaGrupo()
 {
        var valor = document.getElementById("campo3B");
        valor.value ="";
        document.getElementById("sub").value = "0";
        document.getElementById("select").value = "1";
        var valor2 = document.getElementById("campo2B");
        document.busq.action="controlador.php?nuevaBusq=1&campoBusqHost="+
           "&sub=0&campoBusqGrupo="+valor2+"#search";
        document.busq.method="GET";
        document.busq.submit();
 }

  function buscaHost()
 {
    var valor = document.getElementById("campo3B");
    valor.value ="";
    var valor2 = document.getElementById("campo1B").value;
    document.getElementById("sub").value = "1";
    if (valor2==""){
    document.busq.action="controlador.php?nuevaBusq=1&campoBusqHost="+valor2+
           "&sub=1&campoBusqGrupo=#search";
    } else {
    document.busq.action="controlador.php?nuevaBusq=1&campoBusqHost="+valor2+
           "&sub=1&campoBusqGrupo=#allhost0";
    }
    document.busq.method="GET";
    document.busq.submit();
 }


 function buscando(){
    var valor4H = document.getElementById("campo4B").value;
    var valor1H = document.getElementById("campo3B").value;
    var valor2G = document.getElementById("campo2B").value;
    var valor3H = document.getElementById("campo1B").value;
    document.getElementById("sub").value = "1";
    var sub = document.getElementById("sub").value;

    var nuevaBusq = document.getElementById("nuevaBusq").value;
    
    document.busq.action="controlador.php?nuevaBusq=1&submit=1"+
        "&campoBusqHost="+valor3H+
        "&campoBusqHost2="+valor1H+
        "&campoBusqGrupo="+valor2G+
        "&campoBusqGrupo2="+valor4H+
        "&sub="+sub+
        "&nuevaBusq="+nuevaBusq+
        "#allhost0";
    document.busq.method="GET";
    document.busq.submit();
 } 

 function aumentaGraf(){
    document.getElementById("graf").style.display = "none";
    document.getElementById("grafGrande").style.display = "block";
 }

  function decreGraf(){
    document.getElementById("graf").style.display = "block";
    document.getElementById("grafGrande").style.display = "none";
 }


 function ocultaGrupo(id){
     alert("llega");
    //document.getElementById(id).style.display = "none";
 }



function utf8_encode (argString) {
    // Encodes an ISO-8859-1 string to UTF-8
    //
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/utf8_encode    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: sowberry
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman    // +   improved by: Yves Sucaet
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Ulrich
    // +   bugfixed by: Rafal Kukawski
    // *     example 1: utf8_encode('Kevin van Zonneveld');    // *     returns 1: 'Kevin van Zonneveld'
    if (argString === null || typeof argString === "undefined") {
        return "";
    }
     var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    var utftext = "",
        start, end, stringl = 0;

    start = end = 0;stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;
         if (c1 < 128) {
            end++;
        } else if (c1 > 127 && c1 < 2048) {
            enc = String.fromCharCode((c1 >> 6) | 192) + String.fromCharCode((c1 & 63) | 128);
        } else {enc = String.fromCharCode((c1 >> 12) | 224) + String.fromCharCode(((c1 >> 6) & 63) | 128) + String.fromCharCode((c1 & 63) | 128);
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.slice(start, end);}
            utftext += enc;
            start = end = n + 1;
        }
    }
    if (end > start) {
        utftext += string.slice(start, stringl);
    }
     return utftext;
}



function base64_encode (data) {
    // Encodes string using MIME base64 algorithm
    //
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/base64_encode    // +   original by: Tyler Akins (http://rumkin.com)
    // +   improved by: Bayron Guevara
    // +   improved by: Thunder.m
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Pellentesque Malesuada    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Rafał Kukawski (http://kukawski.pl)
    // -    depends on: utf8_encode
    // *     example 1: base64_encode('Kevin van Zonneveld');
    // *     returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='    // mozilla has this native
    // - but breaks in 2.0.0.12!
    //if (typeof this.window['atob'] == 'function') {
    //    return atob(data);
    //}    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        enc = "",
        tmp_arr = [];
    if (!data) {
        return data;
    }
     data = this.utf8_encode(data + '');

    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);o3 = data.charCodeAt(i++);

        bits = o1 << 16 | o2 << 8 | o3;

        h1 = bits >> 18 & 0x3f;h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);

    enc = tmp_arr.join('');
        var r = data.length % 3;


    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}


