<?php
namespace Terminator;

class Out
{
    protected $Style;
    protected $lineBreak;
    protected $char   = 0;
    protected $buffer = '';

    public function __construct($lineBreak = 80, Interfaces\Style $Style = null)
    {
        $this->lineBreak = $lineBreak;
        $this->Style = (is_null($Style)) ? new Style() : $Style;
    }

    public function fg($style = null)
    {
        $this->buffer .= $this->Style->render($style);
        return $this;
    }
    public function bg($style = null)
    {
        $style = (strpos($style, 'bg_') === 0) ? $style : 'bg_' . $style;
        $this->buffer .= $this->Style->render($style);
        return $this;
    }

    public function put($str, $newLines = false)
    {
        if ($this->lineBreak) {
            $this->putAndSplit($str);
        } else {
            $this->buffer .= $str;
        }

        if ($newLines) {
            $this->newLine($newLines);
        }

        return $this;
    }

    public function newLine($n = 1)
    {
        for ($i = 0; $i < $n; $i++) {
            $this->buffer .= PHP_EOL;
        }
        $this->char = 0;

        return $this;
    }

    public function flush($echo = false)
    {
        if ($echo) {
            echo $this->buffer;
            $return = null;
        } else {
            $return = $this->buffer;
        }

        $this->buffer = '';
        return $return;
    }

    protected function putAndSplit($str)
    {
        $len = strlen($str);
        if (($this->char + $len) <= $this->lineBreak) {
            $this->addToBuffer($str);
            return;
        }
        // @todo simplify this?
        if (preg_match('/\s/', $str)) {
            $words = preg_split('/\s/', $str);
            foreach ($words as $index => $word) {
                if ($index !== 0 && ($this->char + strlen($word)) <= $this->lineBreak) {
                    $this->put(' ');
                }
                $this->putAndSplit($word);
            }
        } elseif ($len > $this->lineBreak) {
            $this->putChars($str);
        } else {
            $this->newLine();
            $this->addToBuffer($str);
        }
    }

    protected function addToBuffer($str)
    {
        $this->buffer .= $str;
        $this->char   += strlen($str);
    }

    protected function putChars($str)
    {
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $char = $str[$i];
            $this->addToBuffer($char);
            if ($this->char >= $this->lineBreak) {
                $this->newLine();
            }
        }
    }
}
