<?php

namespace Haruncpi\LaravelH;

use DateTime;

class F
{

    private function makeAttr($attr)
    {
        $attrStr = "";
        foreach ($attr as $key => $value) {
            $attrStr .= '' . $key . '="' . $value . '" ';
        }

        return $attrStr;
    }

    public function getOldValue($name, $value = null)
    {
        if (is_null($name) || is_null($value)) return $value;

        $old = old($name);

        if (!is_null($old) && $name !== '_method') {
            return $old;
        }
    }

    private function makeInput($type, $name, $value, $attr)
    {
        $attr['type'] = $type;
        $attr['name'] = $name;
        $attr['value'] = $this->getOldValue($name, $value);

        return '<input ' . $this->makeAttr($attr) . '>';
    }


    protected function getAction(array $options)
    {

        if (isset($options['url'])) {
            return $this->getUrlAction($options['url']);
        }

        if (isset($options['route'])) {
            return $this->getRouteAction($options['route']);
        } elseif (isset($options['action'])) {
            return $this->getControllerAction($options['action']);
        }

        return url()->current();
    }

    protected function getUrlAction($options)
    {
        if (is_array($options)) {
            return url()->to($options[0], array_slice($options, 1));
        }

        return url()->to($options);
    }

    protected function getRouteAction($options)
    {
        if (is_array($options)) {
            return url()->route($options[0], array_slice($options, 1));
        }

        return url()->route($options);
    }

    protected function getControllerAction($options)
    {
        if (is_array($options)) {
            return url()->action($options[0], array_slice($options, 1));
        }

        return url()->action($options);
    }

    public function open($options = [])
    {
        $append = "";

        $attr['accept-charset'] = 'UTF-8';
        $method = array_key_exists('method', $options) ? strtoupper($options['method']) : 'POST';

        if (!in_array($method, ['GET', 'POST', 'DELETE', 'PATCH', 'PUT'])) {
            $method = "POST";
        }

        $attr['method'] = $method;
        $attr['action'] = $this->getAction($options);
        if (isset($options['files']) && $options['files']) {
            $attr['enctype'] = 'multipart/form-data';
        }

        if ($method !== 'GET') {
            $append .= '<input type="hidden" name="_token" value="' . csrf_token() . '"/>';
        }

        if (in_array($method, ['DELETE', 'PATCH', 'PUT'])) {
            $append .= $this->hidden('_method', $method);
        }

        return "<form " . $this->makeAttr($attr) . ">" . $append;
    }

    public function close()
    {
        return '</form>';
    }

    public function label($name)
    {
        $label = ucwords(str_replace('_', ' ', $name));
        return '<label for="' . $name . '">' . $label . '</label>';
    }

    public function input($type, $name, $value = null, $attr = [])
    {
        return $this->makeInput($type, $name, $value, $attr);
    }

    public function hidden($name, $value = null, $attr = [])
    {
        return $this->makeInput('hidden', $name, $value, $attr);
    }

    public function text($name, $value = null, $attr = [])
    {
        return $this->makeInput('text', $name, $value, $attr);
    }

    public function email($name, $value = null, $attr = [])
    {
        return $this->makeInput('email', $name, $value, $attr);
    }

    public function number($name, $value = null, $attr = [])
    {
        return $this->makeInput('number', $name, $value, $attr);
    }

    public function tel($name, $value = null, $attr = [])
    {
        return $this->makeInput('tel', $name, $value, $attr);
    }

    public function password($name, $value = null, $attr = [])
    {
        return $this->makeInput('password', $name, $value, $attr);
    }

    public function file($name, $value = null, $attr = [])
    {
        return $this->makeInput('file', $name, $value, $attr);
    }


    public function range($name, $value = null, $attr = [])
    {
        return $this->makeInput('range', $name, $value, $attr);
    }

    public function search($name, $value = null, $attr = [])
    {
        return $this->makeInput('search', $name, $value, $attr);
    }

    public function date($name, $value = null, $attr = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $this->makeInput('date', $name, $value, $attr);
    }

    public function datetime($name, $value = null, $attr = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format(DateTime::RFC3339);
        }
        return $this->makeInput('datetime', $name, $value, $attr);
    }

    public function time($name, $value = null, $attr = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('H:i');
        }
        return $this->makeInput('time', $name, $value, $attr);
    }

    public function week($name, $value = null, $attr = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-\WW');
        }

        return $this->makeInput('week', $name, $value, $attr);
    }

    public function url($name, $value = null, $attr = [])
    {
        return $this->makeInput('url', $name, $value, $attr);
    }

    public function textarea($name, $value = null, $attr = [])
    {
        $_value = $this->getOldValue($name, $value);
        return '<textarea name="' . $name . '" ' . $this->makeAttr($attr) . '>' . $_value . '</textarea>';
    }

    public function checkbox($name, $value = 1, $checked = null, $attr = [])
    {
        $_value = $this->getOldValue($name, $value);
        return "<input type=\"checkbox\" name=\"$name\" value=\"$_value\" checked=\"$checked\" " . $this->makeAttr($attr) . "";
    }

    public function radio($name, $value = null, $checked = null, $attr = [])
    {
        $_value = $this->getOldValue($name, $value);
        return "<input type=\"radio\" name=\"$name\" value=\"$_value\" checked=\"$checked\" " . $this->makeAttr($attr) . "";
    }

    public function select($name, $list, $selected = null, $attr = [])
    {
        $_selected = $this->getOldValue($name, $selected);

        if (array_key_exists('placeholder', $attr)) {
            $placeholder = $attr['placeholder'];
            $list = ['' => $placeholder] + $list;
            unset($attr['placeholder']);
        }

        $select = '<select name="' . $name . '" ' . $this->makeAttr($attr) . '>';

        $options = "";
        foreach ($list as $value => $display) {
            $selectedAttr = $value == $_selected ? 'selected' : '';

            $options .= "<option value=\"$value\" $selectedAttr>$display</option>";
        }
        $select .= $options;
        $select .= '</select>';
        return $select;
    }

}
