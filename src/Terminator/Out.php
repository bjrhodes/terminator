<?php
namespace Terminator;

class Out
{
    const ESC_SEQ = "\033[%sm";

    protected $useStyles;
    protected $lineBreak;

    protected $styles = array(
        'reset'            => '0',
        'bold'             => '1',
        'dark'             => '2',
        'italic'           => '3',
        'underline'        => '4',
        'blink'            => '5',
        'reverse'          => '7',
        'concealed'        => '8',

        'default'          => '39',
        'black'            => '30',
        'red'              => '31',
        'green'            => '32',
        'yellow'           => '33',
        'blue'             => '34',
        'magenta'          => '35',
        'cyan'             => '36',
        'light_gray'       => '37',

        'dark_gray'        => '90',
        'light_red'        => '91',
        'light_green'      => '92',
        'light_yellow'     => '93',
        'light_blue'       => '94',
        'light_magenta'    => '95',
        'light_cyan'       => '96',
        'white'            => '97',

        'bg_default'       => '49',
        'bg_black'         => '40',
        'bg_red'           => '41',
        'bg_green'         => '42',
        'bg_yellow'        => '43',
        'bg_blue'          => '44',
        'bg_magenta'       => '45',
        'bg_cyan'          => '46',
        'bg_light_gray'    => '47',

        'bg_dark_gray'     => '100',
        'bg_light_red'     => '101',
        'bg_light_green'   => '102',
        'bg_light_yellow'  => '103',
        'bg_light_blue'    => '104',
        'bg_light_magenta' => '105',
        'bg_light_cyan'    => '106',
        'bg_white'         => '107',
    );

    protected $char   = 0;
    protected $buffer = '';

    public function __construct($useStyles = true, $lineBreak = 80)
    {
        $this->useStyles = $useStyles;
        $this->lineBreak = $lineBreak;
    }

    public function fg($style = null)
    {
        $esc = array_key_exists($style, $this->styles) ? $this->styles[$style] : 0;
        $this->buffer .= sprintf(self::ESC_SEQ, $esc);
        return $this;
    }
    public function bg($style = null)
    {
        $style = 'bg_' . $style;
        $esc = array_key_exists($style, $this->styles) ? $this->styles[$style] : 0;
        $this->buffer .= sprintf(self::ESC_SEQ, $esc);
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
