<?php
    // example of use inside a template or similar.
    require __DIR__ . '/../../src/Autoload.php';
    $Style = new Terminator\Style();
?>
Here's some output I'm going to push to the terminal.

It'll come out all formatted and that, but I want bits of it to be coloured
and junk.

<?= $Style('red') ?>
For example this bit is red
<?= $Style() ?>

<?= $Style('green') ?>
And this bit is green
<?= $Style() ?>

<?= $Style('bg_green') ?><?= $Style('black') ?>
This bit has a green background <?= $Style('bold') ?> with bold text.<?= $Style() ?>

