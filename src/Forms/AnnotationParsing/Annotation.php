<?php

namespace PicoMailPlugin\Forms\AnnotationParsing;

class Annotation {
    public $Content;
    public $Raw;
    public $Start;
    public $Length;

    public function __construct($content, $raw, $start) {
        $this->Content = $content;
        $this->Raw = $raw;
        $this->Start = $start;
        $this->Length = strlen($raw);
    }
}