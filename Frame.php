<?php

class Frame {

    private $routes;

    private function baseUri() {
        return str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    }

    private function requestUri() {
        $junk = 'abcdefg';
        $baseUri = $junk . $this->baseUri();
        $fullUri = $junk . $_SERVER['REQUEST_URI'];
        return '/' . str_replace($baseUri, '', $fullUri);
    }

    public function route($regex, $function) {
        $this->routes[] = array(
            'regex' => $regex,
            'function' => $function
        );
    }

    private function render($data) {
        $html = file_get_contents('templates/' . $data['template']);
        unset($data['template']);
        if (isset($data['activate'])) {
            $html = str_replace('-if-' . $data['activate'], '', $html);
            unset($data['activate']);
        }
        foreach ($data as $var => $val) {
            $html = str_replace('{{ ' . $var . ' }}', $val, $html);
        }
        $html = preg_replace('{{{ asset\((.*?)\) }}}', $this->baseUri() . 'assets/$1', $html);
        $html = preg_replace('{{{ link\((.*?)\) }}}', $this->baseUri() . '$1', $html);
        $html = preg_replace('~>\s*\n\s*<~', '><', $html);
        echo trim($html);
    }

    public function run() {
        foreach ($this->routes as $route) {
            if (preg_match('|^' . $route['regex'] . '(\?(.*))?$|', $this->requestUri(), $matches)) {
                unset($matches[0]);
                $data = call_user_func_array($route['function'], $matches);
            }
        }
        if (!isset($data)) {
            $data = call_user_func('notfound');
        }
        $this->render($data);
    }

}