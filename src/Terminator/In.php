<?php
namespace Terminator;

class In
{
    private $optionDetails = array();

    // @todo extend for users with no readline support
    public function readLine($prompt = null)
    {
        return readline($prompt);
    }

    /**
     * [option description]
     * @param  [type]  $longId     [description]
     * @param  [type]  $shortId    [description]
     * @param  boolean $allowValue [description]
     * @return [type]              [description]
     */
    public function option($longId = null, $shortId = null, $allowValue = false)
    {
        if (is_null($longId) && is_null($shortId)) {
            throw new Exceptions\Terminator("You must supply longId, shortId or both");
        }

    }

    /**
     * [options description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function options(array $options)
    {
        $this->optionDetails = $options;
    }

    public function getOptions(array $options = null)
    {
        $shortopts = $this->buildOptString();
        $longopts  = $this->buildOptArray();

        $raw = getopt($shortopts, $longopts);
        return $this->formatOptions($raw);
    }

    private function buildOptString()
    {

    }

    private function buildOptArray()
    {
        $opts = array(
            "required:",     // Required value
            "optional::",    // Optional value
            "option",        // No value
            "opt",           // No value
        );

        return $opts;
    }
    private function formatOptions(array $options)
    {

    }
}
