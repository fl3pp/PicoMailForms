<?php

namespace PicoMailPlugin\Forms\AnnotationParsing;

class Annotation {
    public $content;
    public $raw;
    public $start;
    public $length;

    public function __construct($content, $raw, $start) {
        $this->content = $content;
        $this->raw = $raw;
        $this->start = $start;
        $this->length = strlen($raw);
    }
}