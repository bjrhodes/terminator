<?php
namespace Terminator;

class In
{
    // @todo extend for users with no native readline support
    public function yesNo($question, $default = "Y")
    {
        if ($default === "Y") {
            $msg = $question . " [Y/n]";
        } else {
            $msg = $question . " [y/N]";
        }

        $response = $this->readline($msg);
        if (trim($response) === '') {
            $char = $default;
        } else {
            $char = strtoupper(substr($response, 0, 1));
        }

        return ($char === "Y");
    }

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
