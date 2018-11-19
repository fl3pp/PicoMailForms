<?php


use PHPUnit\Framework\TestCase;
use PicoMailPlugin\Forms\AnnotationParsing\Annotation;

class AnnotationTest extends TestCase {

    public function test_Length_SetInConstructor_TakesLengthOfRaw() {
        $testee = new Annotation("CONTENT", "[test]CONTENT[/test]", 0, array());

        $result = $testee->Length;

        $this->assertSame(20, $result);
    }

    public function test_Key_SetInConstructor_TakesContentWithoutWhitespaceInLowercase() {
        $testee = new Annotation("I am Content", "[test]I am Content[/test]", 0, array());

        $result = $testee->Key;

        $this->assertSame("i_am_content", $result);
    }
    
}