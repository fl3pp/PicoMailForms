<?php

use PHPUnit\Framework\TestCase;
use PicoMailPlugin\Forms\HtmlFormBuilders\PlainBuilder;

class PlainBuilderTest extends TestCase {

    public function test_addHiddenValue_WithKeyValue_AddsHiddenValue() {
        $testee = new PlainBuilder();

        $testee->addHiddenValue('akey', 'avalue');
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<input type="hidden" name="akey" value="avalue" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addSubmit_ByDefault_AddsSubmitInput() {
        $testee = new PlainBuilder();

        $testee->addSubmit();
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addTextArea_ByDefault_AddsInput() {
        $testee = new PlainBuilder();

        $testee->addTextArea('akey', 'alabel');
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<label for="userdata_akey">alabel</label><br />
<textarea name="userdata_akey" /><br />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_addText_ByDefault_AddsInput() {
        $testee = new PlainBuilder();

        $testee->addText('akey', 'alabel');
        $result = $testee->createHtml();

        $expected = 
'<form method="post">
<label for="userdata_akey">alabel</label><br />
<input type="text" name="userdata_akey" /><br />
</form>';
        $this->assertSame($expected, $result);
    }

}