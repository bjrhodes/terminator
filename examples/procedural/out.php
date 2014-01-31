<?php
require __DIR__ . "/../../src/Autoload.php";
$In  = new Terminator\In();
$Out = new Terminator\Out();
// $ShakeItAll = new About();

echo $Out->newLine()
         ->fg('green')
         ->put('This is green!')
         ->newLine()
         ->fg('red')
         ->fg('bold')
         ->put('now it\'s red!')
         ->newLine()
         ->fg()
         ->put('that is all!')
         ->newLine()
         ->flush(); // don't forget that flush!

if ('someCondition' === true) {
    $Out->fg('black')->bg('light_green')->put('this condition passed!');
} else {
    $Out->fg('white')->bg('red')->put('this condition did NOT pass!');
}

$Out->fg()->bg()->newline();
$Out->flush(true); // echo'ing inline
