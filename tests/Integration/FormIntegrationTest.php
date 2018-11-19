<?php

use PicoMailPlugin\Test\Integration\Setup\IntegrationTestSetup;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase {
    
    public function test_SimpleForm_AddsHtmlForm() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $inputForm = 
'[form]
    [subject]testsubject[/subject]
    [text]Name[/text]
[/form]';

        $testee->setConfig(array());
        $result = $inputForm;
        $testee->prepareContent($result);

        $expected = 
'<form method="post">
<input type="hidden" name="meta_subject" value="testsubject" />
<label for="userdata_Name">Name</label>
<input type="text" name="userdata_Name"  />
<input type="submit" />
<input type="hidden" name="IsPicoMailSend" value="true" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_TwoTexts_AddsHtmlForm() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $inputForm = 
'[form]
    [subject]testsubject[/subject]
    [text]Name[/text]
    [text]Mail[/text]
[/form]';

        $testee->setConfig(array());
        $result = $inputForm;
        $testee->prepareContent($result);

        $expected = 
'<form method="post">
<input type="hidden" name="meta_subject" value="testsubject" />
<label for="userdata_Name">Name</label>
<input type="text" name="userdata_Name"  />
<label for="userdata_Mail">Mail</label>
<input type="text" name="userdata_Mail"  />
<input type="submit" />
<input type="hidden" name="IsPicoMailSend" value="true" />
</form>';
        $this->assertSame($expected, $result);
    }
    
    
    
}