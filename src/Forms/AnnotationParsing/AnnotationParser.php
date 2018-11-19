<?php

namespace PicoMailPlugin\Forms\AnnotationParsing;

class AnnotationParser {

    function getAnnotation($text, $annotationName, &$annotation) : bool {
        if (!$this->getMatch($this->getRegex($annotationName), $text, $match)) {
            return false;
        }
        $annotation = $this->createAnnotation($match);
        return true;
    }

    private function getRegex($annotation) {
        return '/\['.$annotation.'(?<traits>[\w ]*)\](?<content>.*?)\[\/'.$annotation.'\]/si';
    }

    private function getMatch($regex, $text, &$match) {
        return preg_match($regex, $text, $match, PREG_OFFSET_CAPTURE);
    }

    private function createAnnotation($match) {
        $traits = $this->getTraits($match['traits'][0]);
        return new Annotation($match['content'][0], $match[0][0], $match[0][1], $traits);
    }

    private function getTraits($traitsString) {
        $traits = array();
        foreach (explode(' ', $traitsString) as $trait) {
            if (strlen($trait) == 0) continue;
            array_push($traits, $trait);
        }
        return $traits;
    }
}
