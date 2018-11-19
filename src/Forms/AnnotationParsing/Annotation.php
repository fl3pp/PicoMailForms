<?php

namespace PicoMailPlugin\Forms\AnnotationParsing;

class Annotation {
    public $Key;
    public $Content;
    public $Raw;
    public $Start;
    public $Length;
    public $Traits;

    public function __construct($content, $raw, $start, $traits) {
        $this->Key = str_replace(' ', '_', strtolower($content));
        $this->Content = $content;
        $this->Raw = $raw;
        $this->Start = $start;
        $this->Length = strlen($raw);
        $this->Traits = $traits;
    }
}