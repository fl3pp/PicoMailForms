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
<label for="userdata_name">Name</label>
<input type="text" name="userdata_name" />
<input type="hidden" name="meta_success" value="Your form has successfully been send." />
<input type="hidden" name="meta_failed" value="An error occured while sending your message. Please contact the site administrator." />
<input type="hidden" name="meta_picomailsend" value="true" />
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
<label for="userdata_name">Name</label>
<input type="text" name="userdata_name" />
<label for="userdata_mail">Mail</label>
<input type="text" name="userdata_mail" />
<input type="hidden" name="meta_success" value="Your form has successfully been send." />
<input type="hidden" name="meta_failed" value="An error occured while sending your message. Please contact the site administrator." />
<input type="hidden" name="meta_picomailsend" value="true" />
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
<label for="userdata_mail">Mail</label>
<input type="text" name="userdata_mail" />
<input type="hidden" name="meta_mail" value="mail" />
<label for="userdata_firstname">FirstName</label>
<input type="text" name="userdata_firstname" />
<input type="hidden" name="meta_firstname" value="firstname" />
<label for="userdata_address">Address</label>
<input type="text" name="userdata_address" />
<input type="hidden" name="meta_success" value="Your form has successfully been send." />
<input type="hidden" name="meta_failed" value="An error occured while sending your message. Please contact the site administrator." />
<input type="hidden" name="meta_picomailsend" value="true" />
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_SuccessAndFailed_AddsMessagesToHtmlForm() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $inputForm = 
'[form]
    [success]your message has been send[/success]
    [failed]some error[/failed]
[/form]';

        $testee->setConfig(array());
        $result = $inputForm;
        $testee->prepareContent($result);

        $expected = 
'<form method="post">
<input type="hidden" name="meta_subject" value="without subject" />
<input type="hidden" name="meta_success" value="your message has been send" />
<input type="hidden" name="meta_failed" value="some error" />
<input type="hidden" name="meta_picomailsend" value="true" />
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }
    
}