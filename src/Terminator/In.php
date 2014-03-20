<?php
namespace Terminator;

class In
{
    // @todo extend for users with no readline support
    public function readLine($prompt = null)
    {
        return readline($prompt);
    }
}
