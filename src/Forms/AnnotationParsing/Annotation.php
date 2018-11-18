<?php

namespace PicoMailPlugin\Forms\AnnotationParsing;

class Annotation {
    public $start;
    public $length;
    public $raw;
    public $content;

    public function __construct($content, $raw, $start) {
        $this->start = $start;
        $this->length = strlen($content);
        $this->raw = $raw;
        $this->content = $content;
    }
}