<?php

namespace PicoMailPlugin\Forms;

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

class AnnotationFinder {

    function getAnnotation($text, $annotationName, &$annotation) : bool {
        if (!$this->getMatch($this->getRegex($annotationName), $text, $match)) {
            return false;
        }
        $annotation = $this->createAnnotation($match);
        return true;
    }

    private function getRegex($annotation) {
        return '/\['.$annotation.'\](?<content>.*)\[\/'.$annotation.'\]/s';
    }

    private function getMatch($regex, $text, &$match) {
        return preg_match($regex, $text, $match, PREG_OFFSET_CAPTURE);
    }

    private function createAnnotation($match) {
        return new Annotation($match['content'][0], $match[0][0], $match[0][1]);
    }   
}
