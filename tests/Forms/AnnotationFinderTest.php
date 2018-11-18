<?php

use PHPUnit\Framework\TestCase;

class AnnotationFinderTest extends TestCase {

    public function test_SuccessFullTest() {
        $this->assertTrue(true);
    }

    
    public function test_FailingTest() {
        $this->assertTrue(true);
    }
}