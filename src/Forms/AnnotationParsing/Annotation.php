<?php

namespace PicoMailPlugin\Forms\AnnotationParsing;

class Annotation {
    public $Content;
    public $Raw;
    public $Start;
    public $Length;
    public $Traits;

    public function __construct($content, $raw, $start, $traits) {
        $this->Content = $content;
        $this->Raw = $raw;
        $this->Start = $start;
        $this->Length = strlen($raw);
        $this->Traits = $traits;
    }
}