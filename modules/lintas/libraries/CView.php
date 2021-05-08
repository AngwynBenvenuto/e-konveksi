<?php
namespace Lintas\libraries;
class CView {
    protected static $viewFolder = 'template/';
    // The view file name and type
    protected $filename = FALSE;
    protected $filetype = FALSE;
    // CView variable storage
    protected $local_data = array();
    protected static $global_data = array();
    /**
     * Creates a new CView using the given parameters.
     *
     * @param   string  view name
     * @param   array   pre-load data
     * @param   string  type of file: html, css, js, etc.
     * @return  object
     */
    public static function factory($name = NULL, $data = NULL, $type = NULL) {
        return new CView($name, $data, $type);
    }

    public function __construct($name = NULL, $data = NULL, $type = NULL) {
        if (is_string($name) AND $name !== '') {
            // Set the filename
            $this->set_filename($name, $type);
        }

        if (is_array($data) AND ! empty($data)) {
            // Preload data using array_merge, to allow user extensions
            $this->local_data = array_merge($this->local_data, $data);
        }
    }

    public function set_filename($name, $type = NULL) {
        if ($type == NULL) {
            $this->filename = view(self::$viewFolder, $name);
        } else {
            if ($this->filetype == NULL) { 
                $this->filetype = $type;
            }
        }
    }

    public function __isset($key = NULL) {
        return $this->is_set($key);
    }

    public function set($name, $value = NULL) {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->__set($key, $value);
            }
        } else {
            $this->__set($name, $value);
        }

        return $this;
    }

    public function is_set($key = FALSE) {
        $result = FALSE;
        if (is_array($key)) {
            $result = array();
            foreach ($key as $property) {
                $result[$property] = (array_key_exists($property, $this->local_data) OR array_key_exists($property, self::$global_data)) ? TRUE : FALSE;
            }
        } else {
            $result = (array_key_exists($key, $this->local_data) OR array_key_exists($key, self::$global_data)) ? TRUE : FALSE;
        }
        return $result;
    }

    public function bind($name, & $var) {
        $this->local_data[$name] = & $var;
        return $this;
    }
    
    public static function set_global($name, $value = NULL) {
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                self::$global_data[$key] = $value;
            }
        } else {
            self::$global_data[$name] = $value;
        }
    }

    public function __set($key, $value) {
        $this->local_data[$key] = $value;
    }

    public function &__get($key) {
        if (isset($this->local_data[$key]))
            return $this->local_data[$key];

        if (isset(self::$global_data[$key]))
            return self::$global_data[$key];

        if (isset($this->$key))
            return $this->$key;
    }

    public function __toString() {
        try {
            return $this->render();
        } catch (Exception $e) {
            // Display the exception using its internal __toString method
            return (string) $e;
        }
    }

    public static function load_view($view_filename, $input_data = array()) {
        if ($view_filename == '')
            return;
        ob_start();
        extract($input_data, EXTR_SKIP);
        try {
            $result = view($view_filename, $input_data)->render();
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }
        ob_get_clean();
        return $result;
    }

    public function render($print = FALSE, $renderer = FALSE) {
        if (empty($this->filename)) {
            throw new \Exception('File is empty');
        }
        if (is_string($this->filetype)) {
            $data = array_merge(self::$global_data, $this->local_data);
            $output = self::load_view($this->filename, $data);
            if ($renderer !== FALSE AND is_callable($renderer, TRUE)) {
                $output = call_user_func($renderer, $output);
            }
            if ($print === TRUE) {
                echo $output;
                return;
            }
        }
    }
}