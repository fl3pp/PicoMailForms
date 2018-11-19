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

            foreach ($this->getTexts($form->Content) as $text) {
                $htmlBuilder->addText($text->Key, $text->Content);
                $this->processTraits($text, $htmlBuilder);
            }
            
            $htmlBuilder->addHiddenValue(PostConsts::KeySuccess, $this->getSuccess($form->Content));
            $htmlBuilder->addHiddenValue(PostConsts::KeyFailed, $this->getFailed($form->Content));
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
        if(!$this->annotationParser->getAnnotation($content, 'subject', $match)) {
            return "without subject";
        }
        return $match->Content;
    }

    private function getSuccess($content) : string {
        if (!$this->annotationParser->getAnnotation($content, 'success', $match)) {
            return "Your form has successfully been send.";
        }
        return $match->Content;
    }

    private function getFailed($content) : string {
        if (!$this->annotationParser->getAnnotation($content, 'failed', $match)) {
            return "An error occured while sending your message: '{error}'.";
        }
        return $match->Content;
    }

    private function getTexts($content) {
        $contentToSearch = $content;

        $texts = array();
        while ($this->annotationParser->getAnnotation($contentToSearch, 'text', $match)) {
            $contentToSearch = substr($contentToSearch, $match->Start + $match->Length);
            array_push($texts, $match);
        }
        return $texts;
    }

    private function processTraits($text, $htmlBuilder) {
        foreach ($text->Traits as $trait) {
            if (!strcasecmp($trait, PostConsts::TraitMail)) {
                $htmlBuilder->addHiddenValue(PostConsts::KeyMail, $text->Key);
            } else if (!strcasecmp($trait, PostConsts::TraitFirstName)) {
                $htmlBuilder->addHiddenValue(PostConsts::KeyFirstName, $text->Key);
            } else if (!strcasecmp($trait, PostConsts::TraitLastName)) {
                $htmlBuilder->addHiddenValue(PostConsts::KeyLastName, $text->Key);
            }
        }
    }

    private function replaceForm(&$content, $form, $htmlBuilder) {
        $content = substr_replace($content, '', $form->Start, $form->Length);
        $content = substr_replace($content, $htmlBuilder->createHtml(), $form->Start, 0);
    }
}