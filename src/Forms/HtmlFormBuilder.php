<?php

namespace PicoMailPlugin\Forms;

class HtmlFormBuilder {
    private $html = '';

    public function addHiddenValue($key, $value) {
        $this->html .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" >\r\n";
    }

    public function addSubmit() {
        $this->html .= "<input type=\"submit\" />";
    }

    public function addText($name) {
        $this->html .= "<label for=\"userdata_$name\">$name</label>";
        $this->html .= "<input type=\"text\" name=\"userdata_$name\"  />";
    }
    
    public function createHtml() : string {
        $this->addHiddenValue('IsPicoMailSend', 'true');
        return "<form method=\"post\">\r\n$this->html\r\n</form>";
    }

}
