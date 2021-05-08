<?php
namespace Lintas\libraries;

class CStringBuilder {
    private $text = "";
    private $indent = 0;

    public function __construct($str = "") {
        $this->text = $str;
    }

    public static function factory() {
        return new CStringBuilder();
    }

    public function setIndent($ind) {
        $this->indent = $ind;
        return $this;
    }

    /**
     * Get indentation of string
     * 
     * @return int
     */
    public function getIndent() {
        return $this->indent;
    }

    /**
     * Increment the indentation
     * 
     * @param int $n
     * @return $this
     */
    public function incIndent($n = 1) {
        $this->indent += $n;
        return $this;
    }

    public function inc_indent($n = 1) {
        return $this->incIndent($n);
    }

    /**
     * Decrement the indentation
     * 
     * @param int $n
     * @return $this
     */
    public function decIndent($n = 1) {
        $this->indent -= $n;
        return $this;
    }

    public function append($str) {
        $this->text .= $str;
        return $this;
    }

    public function appendln($str) {
        $this->text .= self::indent($this->indent);
        return $this->append($str);
    }

    public function br() {
        $this->text .= "\r\n";
        return $this;
    }

    public function text() {
        return $this->text;
    }

    private static function indent($n, $char = "\t") {
        $res = "";
        for ($i = 0; $i < $n; $i++) {
            $res .= $char;
        }
        return $res;
    }
}


