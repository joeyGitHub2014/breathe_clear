<?php
 require __DIR__ . '\vendor\autoload.php';
 use Rych\Random\Random;
 echo (new Random())->getRandomInteger(1,300);
echo "\n";
echo (new Random())->getRandomBytes(0101);






