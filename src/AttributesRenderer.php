<?php
namespace Germania\AttributesRenderer;


class AttributesRenderer {

    public $template = '%s="%s"';
    public $value_separator = ' ';


    /**
     * @param string $value_separator Optional: How to join attribute values that come as arrays. Default is 1 space character.
     */
    public function __construct($value_separator = null)
    {
        $this->value_separator = (!is_null( $value_separator)) ? $value_separator : $this->value_separator;
    }


    /**
     * @param  string|array $name Attribute name or array of attribute name and value pairs (recursion)
     * @param  string[]     $value
     * @param  string       $value_separator Optional: Override value separator
     * @return string
     */
    public function __invoke($name, $value = null, $value_separator = null) {

        $value_separator = (!is_null( $value_separator)) ? $value_separator : $this->value_separator;

        // Recursion if attribute array given
        if (is_array($name)):
            $attr_strings = [];
            $recursion = $this;
            foreach($name as $n => $v):
                array_push($attr_strings, $recursion($n, $v, $value_separator));
            endforeach;
            return implode($value_separator, array_filter($attr_strings));
        endif;


        // Handle values
        if (empty($value) and !is_string($value)):
            return '';
        elseif (is_string($value)):
            $value = (array) $value;
        endif;

        // Prepare results
        $attr_value_str  = implode($value_separator, $value);

        return sprintf($this->template, $name, $attr_value_str);
    }
}
