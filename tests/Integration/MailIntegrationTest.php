<?php

use PicoMailPlugin\PostConsts;
use PicoMailPlugin\Test\Integration\Setup\IntegrationTestSetup;
use PHPUnit\Framework\TestCase;

class MailIntegrationTest extends TestCase {
    private const defaultConfig = 'PicoMail:
    SenderName: test.ch
    Host: server.test.ch
    UserName: test@test.ch
    Password: test
    Port: 587
    OperatorName: TestUser
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

    public function test_MailWithData_CreatesMail() {
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
        $contentExpected = '<html><body><table><tr><td><b>mail</b></td><td>Mail@Visitor.com</td></tr><tr><td><b>name</b></td><td>Visitor</td></tr></table></body></html>';
        $this->assertSame($contentExpected, $result->Body);
        $this->assertSame('the subject', $result->Subject);
    }
    
    
}



