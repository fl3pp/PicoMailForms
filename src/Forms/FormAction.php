<?php

namespace PicoMailPlugin\Forms;

use PicoMailPlugin\Forms\AnnotationParsing\AnnotationParser;
use PicoMailPlugin\Forms\AnnotationParsing\Annotation;
use PicoMailPlugin\Forms\HtmlFormBuilder;


class FormAction {
    private $config;
    private $annotationFinder;

    public function __construct($config) {
        $this->config = $config;
        $this->annotationFinder = new AnnotationFinder();
    }
        
    public function run(&$content) {
        while($this->getNextForm($content, $form)) {
            $subject = $this->getSubject($form->content);
            
            $htmlBuilder = new HtmlFormBuilder();
            $htmlBuilder->addHiddenValue('meta_subject', $this->getSubject($form->content));

            foreach ($this->getTexts($content) as $text) {
                $htmlBuilder->addText($text->content);
            }
            
            $htmlBuilder->addSubmit();

            $this->replaceForm($content, $form, $htmlBuilder);
        }
    }

    private function getNextForm($content, &$form) : bool {
        if ($this->annotationFinder->getAnnotation($content, 'form', $annotation)) {
            $form = $annotation;
            return true;
        }
        return false;
    }

    private function getSubject($content) : string {
        $subjectFound = $this->annotationFinder->getAnnotation($content, 'subject', $match);

        if(!$subjectFound) {
            return "without subject";
        }
        return $match->content;
    }

    private function getTexts($content) {
        $contentToSearch = $content;

        $texts = array();
        while ($this->annotationFinder->getAnnotation($contentToSearch, 'text', $match)) {
            $contentToSearch = substr($contentToSearch, $match->start + $match->length);
            array_push($texts, $match);
        }
        return $texts;
    }

    private function replaceForm(&$content, $form, $htmlBuilder) {
        $content = substr_replace($content, '', $form->start, $form->length);
        $content = substr_replace($content, $htmlBuilder->createHtml(), $form->start, 0);
    }   
}