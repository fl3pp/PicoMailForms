<?php

namespace PicoMailPlugin\Forms;

use PicoMailPlugin\Forms\AnnotationParsing\AnnotationParser;
use PicoMailPlugin\Forms\AnnotationParsing\Annotation;
use PicoMailPlugin\Forms\HtmlFormBuilder;
use PicoMailPlugin\PostConsts;

class FormAction {
    private $config;
    private $annotationParser;

    public function __construct($config) {
        $this->config = $config;
        $this->annotationParser = new AnnotationParser();
    }
        
    public function run(&$content) {
        while($this->getNextForm($content, $form)) {
            $subject = $this->getSubject($form->Content);
            
            $htmlBuilder = new HtmlFormBuilder();
            $htmlBuilder->addHiddenValue(PostConsts::KeySubject, $this->getSubject($form->Content));

            foreach ($this->getTexts($content) as $text) {
                $htmlBuilder->addText($text);
            }
            
            $htmlBuilder->addHiddenValue(PostConsts::KeyIsPicoMailSend, PostConsts::ValueTrue);
            $htmlBuilder->addSubmit();

            $this->replaceForm($content, $form, $htmlBuilder);
        }
    }

    private function getNextForm($content, &$form) : bool {
        if ($this->annotationParser->getAnnotation($content, 'form', $annotation)) {
            $form = $annotation;
            return true;
        }
        return false;
    }

    private function getSubject($content) : string {
        $subjectFound = $this->annotationParser->getAnnotation($content, 'subject', $match);

        if(!$subjectFound) {
            return "without subject";
        }
        return $match->Content;
    }

    private function getTexts($content) {
        $contentToSearch = $content;

        $texts = array();
        while ($this->annotationParser->getAnnotation($contentToSearch, 'text', $match)) {
            $contentToSearch = substr($contentToSearch, $match->Start + $match->Length);
            array_push($texts, $match->Content);
        }
        return $texts;
    }

    private function replaceForm(&$content, $form, $htmlBuilder) {
        $content = substr_replace($content, '', $form->Start, $form->Length);
        $content = substr_replace($content, $htmlBuilder->createHtml(), $form->Start, 0);
    }   
}