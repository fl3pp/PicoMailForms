<?php

use PicoMailPlugin\PostConsts;
use PicoMailPlugin\Test\Integration\Setup\IntegrationTestSetup;
use PHPUnit\Framework\TestCase;

class MailIntegrationTest extends TestCase {
    private const defaultConfig = 'Mail:
    SenderName: test.ch
    Host: server.test.ch
    UserName: test@test.ch
    Password: test
    Port: 587
    OperatorMail: testuser@test.ch';

    public function test_WithFormSubmitted_SendsMailWithConfiguration() {
        $setup = new IntegrationTestSetup();
        $config = $setup->parseConfig(MailIntegrationTest::defaultConfig);
        $setup->Post->Data[PostConsts::KeyIsPicoMailSend] = PostConsts::ValueTrue;
        $testee = $setup->createTestee();

        $testee->setConfig($config);
        $testee->prepareContent($content);
        
        $result = $setup->MailSender->Mails[0];
        $this->assertTrue($result->IsSmtp);
        $this->assertSame('tls', $result->SmtpSecure);
        $this->assertTrue($result->SmtpAuth);
        $this->assertSame(587, $result->Port);
        $this->assertTrue($result->IsHtml);
    }

    public function test_MailWithData_CreatesMailForCustomer() {
        $setup = new IntegrationTestSetup();
        $config = $setup->parseConfig(MailIntegrationTest::defaultConfig);
        $setup->Post->Data[PostConsts::KeyIsPicoMailSend] = PostConsts::ValueTrue;
        $setup->Post->Data[PostConsts::KeySubject] = "the subject";
        $setup->Post->Data["userdata_mail"] = "Mail@Visitor.com";
        $setup->Post->Data["userdata_name"] = "Visitor";
        $setup->Post->Data[PostConsts::KeyMail] = "mail";
        $setup->Post->Data[PostConsts::KeyFirstName] = "name";
        $testee = $setup->createTestee();
        
        $testee->setConfig($config);
        $testee->prepareContent($content);
        
        $result = $setup->MailSender->Mails[0];
        $this->assertSame('Mail@Visitor.com', $result->To['Visitor']);
        $this->assertSame(1, count($result->To));
        $contentExpected = '<p>Your form has successfully been send.</p><table><tr><td><b>mail</b></td><td>Mail@Visitor.com</td></tr><tr><td><b>name</b></td><td>Visitor</td></tr></table>';
        $this->assertSame($contentExpected, $result->Body);
        $this->assertSame('the subject', $result->Subject);
    }

    public function test_MailSuccessFullWithCustomSuccess_FillsPage() {
        $setup = new IntegrationTestSetup();
        $config = $setup->parseConfig(MailIntegrationTest::defaultConfig);
        $setup->Post->Data[PostConsts::KeyIsPicoMailSend] = PostConsts::ValueTrue;
        $setup->Post->Data[PostConsts::KeySubject] = "the subject";
        $setup->Post->Data["userdata_mail"] = "Mail@Visitor.com";
        $setup->Post->Data["userdata_name"] = "Visitor";
        $setup->Post->Data[PostConsts::KeyMail] = "mail";
        $setup->Post->Data[PostConsts::KeyFirstName] = "name";
        $setup->Post->Data[PostConsts::KeySuccess] = "Your message has been send!";
        $testee = $setup->createTestee();
        
        $testee->setConfig($config);
        $testee->prepareContent($result);
        
        $contentExpected = 
'# the subject

Your message has been send!

<table><tr><td><b>mail</b></td><td>Mail@Visitor.com</td></tr><tr><td><b>name</b></td><td>Visitor</td></tr></table>';
        $this->assertSame($contentExpected, $result);
    }

    public function test_MailSendFailed_OperatorGetsMail() {
        $setup = new IntegrationTestSetup();
        $config = $setup->parseConfig(MailIntegrationTest::defaultConfig);
        $setup->Post->Data[PostConsts::KeyIsPicoMailSend] = PostConsts::ValueTrue;
        $setup->Post->Data[PostConsts::KeySubject] = "the subject";
        $setup->Post->Data["userdata_mail"] = "Mail@Visitor.com";
        $setup->Post->Data["userdata_name"] = "Visitor";
        $setup->Post->Data[PostConsts::KeyMail] = "mail";
        $setup->Post->Data[PostConsts::KeyFirstName] = "name";
        $setup->Post->Data[PostConsts::KeySuccess] = "Your message has been send!";
        $result = $setup->MailSender->Succeeds = false;
        $result = $setup->MailSender->Message = 'The users mail is not valid.';
        $testee = $setup->createTestee();
        
        $testee->setConfig($config);
        $testee->prepareContent($result);
        
        $result = $setup->MailSender->Mails[1];
        $this->assertSame(1, count($result->To));
        $this->assertSame('testuser@test.ch', $result->To['Operator']);
        $expectedBody = '<p>A error occured while a user tried to fill your form: the subject</p><p>ERROR: The users mail is not valid.</p><table><tr><td><b>mail</b></td><td>Mail@Visitor.com</td></tr><tr><td><b>name</b></td><td>Visitor</td></tr></table>';
        $this->assertSame($expectedBody, $result->Body);
    }

    public function test_MailSendWithSpecialCharsMessage_EscapesChars() {
        $setup = new IntegrationTestSetup();
        $config = $setup->parseConfig(MailIntegrationTest::defaultConfig);
        $setup->Post->Data[PostConsts::KeyIsPicoMailSend] = PostConsts::ValueTrue;
        $setup->Post->Data["userdata_mail"] = "Mail@Visitor.com";
        $setup->Post->Data["userdata_name"] = "Visitor";
        $setup->Post->Data[PostConsts::KeyMail] = "mail";
        $setup->Post->Data[PostConsts::KeyFirstName] = "name";
        $setup->Post->Data[PostConsts::KeySuccess] = "These are some special chars: <";
        $testee = $setup->createTestee();

        $testee->setConfig($config);
        $testee->prepareContent($result);

        $result = $setup->MailSender->Mails[0];
        $expectedBody = '<p>These are some special chars: &lt;</p><table><tr><td><b>mail</b></td><td>Mail@Visitor.com</td></tr><tr><td><b>name</b></td><td>Visitor</td></tr></table>';
        $this->assertSame($expectedBody, $result->Body);
    }
}
