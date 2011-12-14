<?php
$key='#abc123.String_Para_Codificar#abc123.';

function encode_values($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return $hash;
}

function decode_values($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function decode($texto){
$text=$texto;
$text = str_replace(
array("\xe2\x82\xac", "\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
array(" Euros", "'", "'", '"', '"', '-', '--', '...'),$text);

// Next, replace their Windows-1252 equivalents.
$text = str_replace(
array(chr(128), chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
array(" Euros","'", "'", '"', '"', '-', '--', '...'),$text);

return (utf8_encode($text));
}

php?>
