<?php
header("Content-type: text/html; Charset=utf-8");

function print_arr($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

$str1 = 'Cat суПер пупЕр Мышь houSe домИК elEpHant ';
$str2 = 'cat, Зима: is ';
$str3 = "'cold' ";
$str4 = 'now это «Так» "просто" third-part can`t';
$original = $str1 . $str2 . $str3 . $str4;

echo ($original); echo "<br/>"; echo "<br/>";
/*
Cat суПер пупЕр Мышь houSe домИК elEpHant cat, Зима: is 'cold' now это «Так» "просто" third-part can`t
*/
$array = array();

$array = preg_split('# #', $original);
$reversed = string_reverse($array);
echo ($reversed); echo "<br/>"; echo "<br/>";
/*
tac репус репуп ьшым esuoh кимод tnahpele tac, амиз: si 'dloc' won отэ «Так» "отсорп" driht-trap nac`t
 */
//print_arr($array);
$changed = change_registr($original, $reversed);
echo ($changed); echo "<br/>"; echo "<br/>";
/*
Tac реПус репУп Ьшым esuOh кимОД tnAhPele tac, Амиз: si 'dloc' won отэ «Так» "отсорп" driht-trap nac`t
*/

function change_registr($str1, $str2)
{
//    $characters = preg_split('/(?<!^)(?!$)/u', $str1);
//    print_arr($characters);
    $changed = '';
    $l = mb_strlen($str1, "UTF-8");
    for ($i = 0; $i < $l; $i++)
    {
        $char1 = mb_substr ($str1, $i, 1, "UTF-8");
        $char2 = mb_substr ($str2, $i, 1, "UTF-8");
        if (mb_strtolower($char1, "UTF-8") != $char1) {
            $char2 = mb_strtoupper($char2, 'UTF-8');
        }
        $changed .= $char2;
    }
    return $changed;
}

function string_reverse($array)
{
    foreach ($array as $k => $v) {
        /* Слова в двойных горизонтальных кавычках «...» */
        if (preg_match('#«(\S+)»#', $v)) {
            $arr[] = $v;
        } else {
            /* Слова в двойных вертикальных кавычках '' "" */
            if (preg_match('#\'(\S+)\'|\"(\S+)\"#', $v)) {
                $arr[] = mb_strtolower(mb_strrev($v));
            } else {
                /* Слова с пунктуацией , : . */
                if (preg_match('#(\S+)([,:\.])$#', $v, $matches)) {
                    $arr[] = mb_strtolower(mb_strrev($matches[1])) . $matches[2];
                } else {
                    /* Составные слова с разделителями - ` */
                    if (preg_match('#(\S+)([-`])(\S+)#', $v, $matches)) {
                        $arr[] = mb_strtolower(mb_strrev($matches[1]) . $matches[2] . mb_strrev($matches[3]));
                    } else {
                        /* Составные слова с разделителем   */
                        if (preg_match('#(\S+)([ ])(\S+)#', $v, $matches)) {
                            $l = mb_strlen($matches[1], "UTF-8");
                            $str1 = mb_substr($matches[1], 0, $l - 1, "UTF-8");
                            $str2 = " ";
                            $arr[] = mb_strtolower(mb_strrev($str1) . $str2 . mb_strrev($matches[3]));
                        } else {
                            /* Одиночные слова */
                            $arr[] = mb_strtolower(mb_strrev($v));
                        }
                    }
                }
            }
        }
    }
    return implode(' ', $arr);
}

function mb_strrev($string, $encoding = null)
/* https://kvz.io/blog/reverse-a-multibyte-string-in-php.html */
{
    if ($encoding === null)
    {
        $encoding = mb_detect_encoding($string);
    }

    $length   = mb_strlen($string, $encoding);
    $reversed = '';
    while ($length-- > 0)
    {
        $reversed .= mb_substr($string, $length, 1, $encoding);
    }

    return $reversed;
}
