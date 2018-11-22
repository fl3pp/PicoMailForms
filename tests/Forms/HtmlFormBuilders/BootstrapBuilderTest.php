<?php

use PHPUnit\Framework\TestCase;
use PicoMailPlugin\Forms\HtmlFormBuilders\BootstrapBuilder;

class BootstrapTest extends TestCase {

    public function test_addHiddenValue_WithKeyValue_AddsHiddenValue() {
        $testee = new BootstrapBuilder();

        $testee->addHiddenValue('akey', 'avalue');
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<input type="hidden" name="akey" value="avalue" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addSubmit_ByDefault_AddsSubmitInput() {
        $testee = new BootstrapBuilder();

        $testee->addSubmit();
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<input type="submit" class="btn btn-primary" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addTextArea_ByDefault_AddsInput() {
        $testee = new BootstrapBuilder();

        $testee->addTextArea('akey', 'alabel', false);
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<div class="form-group">
   <label for="userdata_akey">alabel</label>
   <textarea class="form-control" rows="5" name="userdata_akey" />
</div>
</form>';
        $this->assertSame($expected, $result, false);
    }

    public function test_addTextArea_WithRequired_AddsInput() {
        $testee = new BootstrapBuilder();

        $testee->addTextArea('akey', 'alabel', true);
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<div class="form-group">
   <label for="userdata_akey">alabel</label>
   <textarea class="form-control" rows="5" name="userdata_akey" required/>
</div>
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addText_ByDefault_AddsInput() {
        $testee = new BootstrapBuilder();

        $testee->addText('akey', 'alabel', false);
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<div class="form-group">
   <label for="userdata_akey">alabel</label>
   <input class="form-control" type="text" name="userdata_akey" />
</div>
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addText_Required_AddsInput() {
        $testee = new BootstrapBuilder();

        $testee->addText('akey', 'alabel', true);
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<div class="form-group">
   <label for="userdata_akey">alabel</label>
   <input class="form-control" type="text" name="userdata_akey" required/>
</div>
</form>';
        $this->assertSame($expected, $result);
    }

}