<?php

namespace PicoMailPlugin\Forms;

use PicoMailPlugin\PostConsts;

class HtmlFormBuilder {
    private $html = '';

    public function addHiddenValue($key, $value) {
        $key = $this->simplifyName($key);
        $this->html .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />\r\n";
    }

    public function addSubmit() {
        $this->html .= "<input type=\"submit\" />\r\n";
    }

    public function addText($name) {
        $inputName = $this->simplifyName(PostConsts::PrefixUserdata.$name);
        $this->html .= '<label for="'.$inputName.'">'.$name.'</label>'."\r\n";
        $this->html .= '<input type="text" name="'.$inputName.'" />'."\r\n";
    }
    
    public function createHtml() : string {
        return "<form method=\"post\">\r\n$this->html</form>";
    }

    private function simplifyName($name) {
        return str_replace(' ', '_', strtolower($name));
    }
}
