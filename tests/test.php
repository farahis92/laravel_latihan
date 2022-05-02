<?php
function toUpperCase(String $value):String {
    return strtoupper($value);
}

function sayHallo(String $name, callable $callback = null):String {
    if(!is_null($callback) && isset($callback)) {
        return $callback($name);
    } else {
        return $name;
    }
//    return call_user_func($callback, $name);
}

$name = sayHallo("fajar rahmadi", 'toUpperCase');
print($name);

////////////////////////

echo  PHP_EOL;

$danang = sayHallo("danang", function(String $name) {
   return strtoupper($name);
});

print($danang);

class User {
    const name = "USERNAME";
}

$f1 = new User();

echo PHP_EOL;


function kocaks($v1, $v2 = 0): int|float
{
    if(!is_int($v1) || !is_int($v2)) {
        throw new Exception("MASUKAN INTEGER");
    }
    return  $v1+$v2;
}

$ff = kocaks(2,4);
print($ff);
