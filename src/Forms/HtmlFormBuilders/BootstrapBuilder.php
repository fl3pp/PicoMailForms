<?php

namespace PicoMailPlugin\Forms\HtmlFormBuilders;

use PicoMailPlugin\PostConsts;

class BootstrapBuilder {
    private $html = '';

    public function addHiddenValue($key, $value) {
        $this->html .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />\r\n";
    }

    public function addSubmit() {
        $this->html .= "<input type=\"submit\" class=\"btn btn-primary\" />\r\n";
    }

    public function addTextArea($key, $label) {
        $inputName = PostConsts::PrefixUserdata.$key;
        $this->html .= '<div class="form-group">'."\r\n";
        $this->html .= '   <label for="'.$inputName.'">'.$label.'</label>'."\r\n";
        $this->html .= '   <textarea class="form-control" rows="5" name="'.$inputName.'" />'."\r\n";
        $this->html .= '</div>'."\r\n";
    }

    public function addText($key, $label) {
        $inputName = PostConsts::PrefixUserdata.$key;
        $this->html .= '<div class="form-group">'."\r\n";
        $this->html .= '   <label for="'.$inputName.'">'.$label.'</label>'."\r\n";
        $this->html .= '   <input class="form-control" type="text" name="'.$inputName.'" />'."\r\n";
        $this->html .= '</div>'."\r\n";
    }
    
    public function createHtml() : string {
        return "<form method=\"post\">\r\n$this->html</form>";
    }
}
