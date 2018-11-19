<?php

use PicoMailPlugin\Test\Integration\Setup\IntegrationTestSetup;
use PHPUnit\Framework\TestCase;

class FormIntegrationTest extends TestCase {
    
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
<input type="text" name="userdata_Name" />
<input type="hidden" name="IsPicoMailSend" value="true" />
<input type="submit" />
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
<input type="text" name="userdata_Name" />
<label for="userdata_Mail">Mail</label>
<input type="text" name="userdata_Mail" />
<input type="hidden" name="IsPicoMailSend" value="true" />
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }
    
    public function test_MailTrait_AddsHtmlForm() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $inputForm = 
'[form]
    [subject]testsubject[/subject]
    [text mail]Mail[/text]
    [text firstname]FirstName[/text]
    [text]Address[/text]
[/form]';

        $testee->setConfig(array());
        $result = $inputForm;
        $testee->prepareContent($result);

        $expected = 
'<form method="post">
<input type="hidden" name="meta_subject" value="testsubject" />
<label for="userdata_Mail">Mail</label>
<input type="text" name="userdata_Mail" />
<input type="hidden" name="meta_mail" value="Mail" />
<label for="userdata_FirstName">FirstName</label>
<input type="text" name="userdata_FirstName" />
<input type="hidden" name="meta_firstname" value="FirstName" />
<label for="userdata_Address">Address</label>
<input type="text" name="userdata_Address" />
<input type="hidden" name="IsPicoMailSend" value="true" />
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }
    
}