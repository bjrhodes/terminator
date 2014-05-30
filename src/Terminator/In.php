<?php
namespace Terminator;

class In
{
    // @todo extend for users with no readline support
    public function readLine($prompt = null)
    {
        return readline($prompt);
    }

    public function getParameters()
    {
        global $argv;
        $params = (array) $argv;

        if (count($params)) {     // might not be called in cli context?!
            array_shift($params); // lose the script name
        }

        return $params;
    }
}
