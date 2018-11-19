<?php

namespace PicoMailPlugin\Forms;

class HtmlFormBuilder {
    private $html = '';

    public function addHiddenValue($key, $value) {
        $this->html .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />\r\n";
    }

    public function addSubmit() {
        $this->html .= "<input type=\"submit\" />\r\n";
    }

    public function addText($name) {
        $this->html .= "<label for=\"userdata_$name\">$name</label>\r\n";
        $this->html .= "<input type=\"text\" name=\"userdata_$name\"  />\r\n";
    }
    
    public function createHtml() : string {
        $this->addHiddenValue('IsPicoMailSend', 'true');
        return "<form method=\"post\">\r\n$this->html</form>";
    }

}
