<?php
namespace Terminator;

class NoStyle implements Interfaces\Style
{
    public function __invoke($style)
    {
        return '';
    }

    public function render($style)
    {
        return '';
    }
}
