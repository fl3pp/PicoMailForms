<?php

use PicoMailPlugin\PostConsts;
use PicoMailPlugin\Test\Integration\Setup\IntegrationTestSetup;
use PHPUnit\Framework\TestCase;

class MailIntegrationTest extends TestCase {

    public function test_WithFormSubmitted_SendsMailWithConfiguration() {
        $setup = new IntegrationTestSetup();
        $config = $setup->parseConfig('
PicoMail:
    SenderName: test.ch
    Host: server.test.ch
    UserName: test@test.ch
    Password: test
    Port: 587
    OperatorName: TestUser
    OperatorMail: testuser@test.ch');
        $setup->Post->Data[PostConsts::KeyIsPicoMailSend] = PostConsts::ValueTrue;
        $setup->Post->Data[PostConsts::KeySubject] = "the subject";
        $setup->Post->Data[PostConsts::PrefixUserdata . "Name"] = "Visitor";
        $setup->Post->Data[PostConsts::PrefixUserdata . "Mail"] = "Mail@Visitor.com";
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
    
    
}



