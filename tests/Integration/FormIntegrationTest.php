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
<label for="userdata_name">Name</label><br />
<input type="text" name="userdata_name" /><br />
<input type="hidden" name="meta_picomailsend" value="true" />
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_TwoTextsAndTextArea_AddsHtmlForm() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $inputForm = 
'[form]
    [subject]testsubject[/subject]
    [text]Name[/text]
    [text]Mail[/text]
    [textarea]Message[/textarea]
[/form]';

        $testee->setConfig(array());
        $result = $inputForm;
        $testee->prepareContent($result);

        $expected = 
'<form method="post">
<input type="hidden" name="meta_subject" value="testsubject" />
<label for="userdata_name">Name</label><br />
<input type="text" name="userdata_name" /><br />
<label for="userdata_mail">Mail</label><br />
<input type="text" name="userdata_mail" /><br />
<label for="userdata_message">Message</label><br />
<textarea name="userdata_message" /><br />
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
<label for="userdata_mail">Mail</label><br />
<input type="text" name="userdata_mail" /><br />
<input type="hidden" name="meta_mail" value="mail" />
<label for="userdata_firstname">FirstName</label><br />
<input type="text" name="userdata_firstname" /><br />
<input type="hidden" name="meta_firstname" value="firstname" />
<label for="userdata_address">Address</label><br />
<input type="text" name="userdata_address" /><br />
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
<input type="hidden" name="meta_success" value="your message has been send" />
<input type="hidden" name="meta_failed" value="some error" />
<input type="hidden" name="meta_picomailsend" value="true" />
<input type="submit" />
</form>';
        $this->assertSame($expected, $result);
    }

    public function test_UseBootstrapTrue_UsesBootstrap() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $config = $setup->parseConfig("Forms:\r\n   UseBootstrap: true");
        $inputForm = 
'[form]
    [text]test[/text]
[/form]';

        $testee->setConfig($config);
        $result = $inputForm;
        $testee->prepareContent($result);

        $expected = 
'<form method="post">
<div class="form-group">
   <label for="userdata_test">test</label>
   <input class="form-control" type="text" name="userdata_test" />
</div>
<input type="hidden" name="meta_picomailsend" value="true" />
<input type="submit" class="btn btn-primary" />
</form>';
        $this->assertSame($expected, $result);

        
    }        
    
}