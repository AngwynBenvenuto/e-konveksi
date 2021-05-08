<?php
namespace Lintas\libraries;
class CException extends \Exception {
    public function __construct($message = "", array $variables = NULL, $code = 0, Exception $previous = NULL) {
        if (is_array($variables)) {
            $message = strtr($message, $variables);
        }
        // Pass the message and integer code to the parent
        parent::__construct($message, $code, $previous);
    }
}