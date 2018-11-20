<?php

namespace PicoMailPlugin\Forms;

use PicoMailPlugin\Forms\AnnotationParsing\AnnotationParser;
use PicoMailPlugin\Forms\AnnotationParsing\Annotation;
use PicoMailPlugin\Forms\HtmlFormBuilder;
use PicoMailPlugin\PostConsts;
use PicoMailPlugin\Forms\FormConfigKeys;

class FormAction {
    private $config;
    private $annotationParser;

    public function __construct($config) {
        $this->config = $config;
        $this->annotationParser = new AnnotationParser();
    }

    public function run(&$content) {
        while($this->getNextForm($content, $form)) {
            $htmlBuilder = $this->getHtmlBuilder();

            $this->processSubject($form->Content, $htmlBuilder);
            $this->processSuccessMessage($form->Content, $htmlBuilder);
            $this->processFailedMessage($form->Content, $htmlBuilder);
            $this->processTexts($form->Content, $htmlBuilder);
            $this->processPicoMailSend($htmlBuilder);
            $this->processSubmit($htmlBuilder);

            $this->replaceForm($content, $form, $htmlBuilder);
        }
    }

    private function getHtmlBuilder() {
        $useBootstrap = false;
        if (array_key_exists(FormConfigKeys::YamlSection, $this->config)){
            if (array_key_exists(FormConfigKeys::UseBootstrap, $this->config[FormConfigKeys::YamlSection])) {
                $useBootstrap = 
                    $this->config[FormConfigKeys::YamlSection][FormConfigKeys::UseBootstrap] 
                    == 
                    PostConsts::ValueTrue;
            }
        }
        return $useBootstrap 
            ? new \PicoMailPlugin\Forms\HtmlFormBuilders\BootstrapBuilder()
            : new \PicoMailPlugin\Forms\HtmlFormBuilders\PlainBuilder();
    }

    private function getNextForm($content, &$form) : bool {
        if ($this->annotationParser->getAnnotation($content, 'form', $annotation)) {
            $form = $annotation;
            return true;
        }
        return false;
    }

    private function processSubject($content, $htmlBuilder) {
        if($this->annotationParser->getAnnotation($content, 'subject', $match)) {
            $htmlBuilder->addHiddenValue(PostConsts::KeySubject, $match->Content);
        }
    }

    private function processSuccessMessage($content, $htmlBuilder) {
        if ($this->annotationParser->getAnnotation($content, 'success', $match)) {
            $htmlBuilder->addHiddenValue(PostConsts::KeySuccess, $match->Content);
        }
    }

    private function processFailedMessage($content, $htmlBuilder) {
        if ($this->annotationParser->getAnnotation($content, 'failed', $match)) {
            $htmlBuilder->addHiddenValue(PostConsts::KeyFailed, $match->Content);
        }
    }

    private function processTexts($content, $htmlBuilder) {
        $contentToSearch = $content;
        while ($this->annotationParser->getAnnotation($contentToSearch, 'text', $match)) {
            $contentToSearch = substr($contentToSearch, $match->Start + $match->Length);
            $this->processText($match, $htmlBuilder);
            $this->processTraits($match, $htmlBuilder);
        }
    }

    private function processText($text, $htmlBuilder) {
        $htmlBuilder->addText($text->Key, $text->Content);
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

    private function processPicoMailSend($htmlBuilder) {
        $htmlBuilder->addHiddenValue(PostConsts::KeyIsPicoMailSend, PostConsts::ValueTrue);
    }

    private function processSubmit($htmlBuilder) {
        $htmlBuilder->addSubmit();
    }

    private function replaceForm(&$content, $form, $htmlBuilder) {
        $content = substr_replace($content, '', $form->Start, $form->Length);
        $content = substr_replace($content, $htmlBuilder->createHtml(), $form->Start, 0);
    }
}