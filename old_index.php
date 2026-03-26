<?php
header("Content-type: text/html; Charset=utf-8");

/*Техническое задание
Напиши метод, который принимает на вход строку и меняет порядок букв в каждом слове на обратный:
- с сохранением регистра (например,
    'Cat' -> 'Tac', 'Мышь' -> 'Ьшым', 'houSe' -> 'esuOh', 'домИК' -> 'кимОД', 'elEpHant' -> 'tnAhPele'
- регистр сохраняется в соответствии с позицией прописных и строчных букв в первоначальном слове);
- с сохранением пунктуации (например,
    'cat,' -> 'tac,', 'Зима:' -> 'Амиз:', "is 'cold' now" -> "si 'dloc' won", 'это «Так» "просто"' -> 'отэ «Так» "отсорп"'
- знаки препинания остаются на своих местах).
Обрати внимание: составные слова, содержащие дефис(ы) и/или апостроф(ы),   считаются отдельными словами с символами-разделителями между ними
(например, 'third-part' -> 'driht-trap', 'can`t' -> 'nac`t').
Могут использоваться буквы из любых языков, не только английского.
Также напиши unit-тесты для этого метода.
Результат выложи на github и пришли ссылку.*
*/
/*
Array
(
    [0] => Cat
    [1] => супер пупер
    [2] => Мышь
    [3] => houSe
    [4] => домИК
    [5] => elEpHant
    [6] => cat,
    [7] => Зима:
    [8] => "is
    [9] => 'cold'
    [10] => now"
    [11] => это
    [12] => «Так»
    [13] => "просто"
    [14] => third-part
    [15] => can`t
)
*/


function print_arr($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

$str1 = 'Cat супер пупер Мышь houSe домИК elEpHant';
$str2 = 'cat, Зима: "is ';
$str3 = "'cold' ";
$str4 = 'now" ';
$str5 = 'это «Так» "просто" third-part can`t';
$str = $str1 . $str2 . $str3 . $str4 . $str5;

//$str = 'Привет, мир! é ٢٦ ﬧ ¼ ¾ Ёёж 13212 ไ  ﬧ _ Hello, world!';
//$str = 'Д`обро1 пожаловать, в "супер пупер:" «Википедию»! W`elcome2 to, "super  duper:" «Wikipedia»! ¡`Bienvenido3, a la "súper   tonta:" «Wikipedia»!';

$chars = preg_split('# #', $str, -1, PREG_SPLIT_OFFSET_CAPTURE);
/*
print_arr($chars);
    ...
    [11] => Array
    (
        [0] => «Так»
        [1] => 99
    )
    ...
*/

//print_arr(string_reverse($chars));

function string_reverse($chars)
{
    $ar1 = [];
    $ar2 = [];
    foreach ($chars as $k => $v)
    {
        $ar1[] = $v[0];
        $ar2[] = mb_strtolower($v[0]);
    }
print_arr($ar1);

    $arl = count($ar1);
    for ($i = 0; $i < $arl; $i++)
    {
        preg_match_all('#\p{L}*#u', $ar1[$i], $matches1, PREG_SET_ORDER);
//        print_arr($matches1);
        preg_match_all('#\p{L}*#u', $ar2[$i], $matches2, PREG_SET_ORDER);
//        print_arr($matches2);

        foreach ($matches2 as &$value)
        {
//            $newArray [] = array_push($item => $value);

//            print_arr($value);

            foreach ($value as &$v)
            {
//                print_arr($v);
                $v = mb_strrev($v);
//                print_arr($v);
            }

        }

//        $newArray = array_merge_numbered($matches2);
//        print_arr($newArray);

        /*$l = mb_strlen($ar1[$i]);
        if (mb_strtolower($ch, "UTF-8") != $ch)
        {
            $ch = mb_strtolower($ch, 'UTF-8');
        } else
        {
            $ch = mb_strtoupper($ch, 'UTF-8');
        }
        $ar2[$k] = $ch;*/

    }

//    return implode('', $ar1);

//    print_arr($ar1);
    return $ar2;
}

function mb_strrev($string, $encoding = null)
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

/*
function array_merge_numbered($array)
{
    $newarray = array();
    $i = 0;
    foreach ($array as $item => $value)
    {
        $j = 0;
        foreach ($value as $v)
        {
            $newarray[$i][$j][0] = $v;
            $j++;
        }
        $i++;
    }
    return $newarray;
}
*/

//===================================================================================================================================================

/*
    $tests = ['Ёё', 'âa', 'Bbbbb', 'Éé', 'iou', 'Δδ'];
    foreach ($tests as $test)
    {
        echo "{$test}:";
        echo "<br/>";
        echo "PREG:  " , preg_match('~^\p{Lu}~u', $test)      ? 'upper' : 'lower';
        echo "<br/>";
        echo "CTYPE: " , ctype_upper(mb_substr($test, 0, 1))  ? 'upper' : 'lower';
        echo "<br/>";
        echo "< a:   " , mb_substr($test, 0, 1) < 'a'         ? 'upper' : 'lower';
        echo "<br/>";

        $chr = mb_substr ($test, 0, 1, "UTF-8");
        echo "MB:    " , mb_strtoupper($chr, "UTF-8") == $chr ? 'upper' : 'lower';
        echo "<br/>";
        echo "<br/>";
    }
*/

//===================================================================================================================================================
/*
    $str = "Cat |     | Мышь | houSe |домИК | elEpHant | cat | Зима: | is 'cold' now | это «Так» 'просто' | third-part can`t";
    $pattern = '/(?<!^)(?!$)/u';
    $chars = preg_split($pattern, $str);
    implode('|', $chars);
    print_arr($chars);
*/
