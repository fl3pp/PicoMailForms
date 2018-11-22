<?php

namespace PicoMailPlugin\Forms\HtmlFormBuilders;

use PicoMailPlugin\PostConsts;

class PlainBuilder {
    private $html = '';

    public function addHiddenValue($key, $value) {
        $this->html .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />\r\n";
    }

    public function addSubmit() {
        $this->html .= "<input type=\"submit\" />\r\n";
    }

    public function addTextArea($key, $label) {
        $inputName = PostConsts::PrefixUserdata.$key;
        $this->html .= '<label for="'.$inputName.'">'.$label.'</label><br />'."\r\n";
        $this->html .= '<textarea name="'.$inputName.'" /><br />'."\r\n";
    }

    public function addText($key, $label) {
        $inputName = PostConsts::PrefixUserdata.$key;
        $this->html .= '<label for="'.$inputName.'">'.$label.'</label><br />'."\r\n";
        $this->html .= '<input type="text" name="'.$inputName.'" /><br />'."\r\n";
    }
    
    public function createHtml() : string {
        return "<form method=\"post\">\r\n$this->html</form>";
    }
}
