<?php

declare(strict_types=1);

$functions = [
    function($next) {
        echo "A <br>";
        $next();
        echo "After Main Content";
    },
     function($next) {
        echo "B <br>";
        $next();
        //echo "After B Content";
    },
     function($next) {
        echo "C <br>";
        $next();
        //echo "After C Content";
    }
];


$a = function() {
    echo "Main Content <br>";
};

foreach($functions as $function) {
    $a = fn() => $function($a);
}

$a();