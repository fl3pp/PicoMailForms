<?php

use PHPUnit\Framework\TestCase;
use PicoMailPlugin\Forms\AnnotationParsing\AnnotationParser;

class AnnotationParserTest extends TestCase {

    public function test_getAnnotation_CorrectAnnotation_ReturnsAnnotation() : void {
        $testee = new AnnotationParser();
        $text = '[text]test[/text]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertTrue($result);
        $this->assertSame($annotation->start, 0);
        $this->assertSame($annotation->content, 'test');
        $this->assertSame($annotation->raw, $text);
    }

    public function test_getAnnotation_PrependedText_ReturnsAnnotation() : void {
        $testee = new AnnotationParser();
        $text = 'asdf[text]test[/text]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertTrue($result);
        $this->assertSame($annotation->start, 4);
        $this->assertSame($annotation->content, 'test');
    }

    public function test_getAnnotation_WithoutEnding_ReturnsFalse() : void {
        $testee = new AnnotationParser();
        $text = 'asdf[text]test[text]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertFalse($result);
    }
}