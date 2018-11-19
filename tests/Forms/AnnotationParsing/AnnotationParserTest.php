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
        $this->assertSame($annotation->Start, 0);
        $this->assertSame($annotation->Content, 'test');
        $this->assertSame($annotation->Raw, $text);
    }

    public function test_getAnnotation_UpperCaseAnnotation_ReturnsAnnotation() : void {
        $testee = new AnnotationParser();
        $text = '[text]content[/TEXT]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertTrue($result);
        $this->assertSame($annotation->Content, 'content');
    }

    public function test_getAnnotation_PrependedText_ReturnsAnnotation() : void {
        $testee = new AnnotationParser();
        $text = 'asdf[text]test[/text]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertTrue($result);
        $this->assertSame($annotation->Start, 4);
        $this->assertSame($annotation->Content, 'test');
    }

    public function test_getAnnotation_TwoAnnotations_ReturnsFirstAnnotation() : void {
        $testee = new AnnotationParser();
        $text = '[text]test[/text][text]another[/text]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertTrue($result);
        $this->assertSame($annotation->Content, 'test');
    }
    
    public function test_getAnnotation_WithoutEnding_ReturnsFalse() : void {
        $testee = new AnnotationParser();
        $text = 'asdf[text]test[text]';
        $annotationName = 'text';
        
        $result = $testee->getAnnotation($text, $annotationName, $annotation);
        
        $this->assertFalse($result);
    }
}