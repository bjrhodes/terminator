<?php
namespace Terminator\Interfaces;

interface Style
{
    public function __invoke($style);
    public function render($style);
}
