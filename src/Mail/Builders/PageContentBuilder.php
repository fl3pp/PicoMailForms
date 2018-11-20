<?php

namespace PicoMailPlugin\Mail\Builders;

class PageContentBuilder {
    private $contentCreator;

    public function __construct($contentCreator) {
        $this->contentCreator = $contentCreator;
    }

    public function buildContent(&$content, $userMailSuccessFull) {
        $content = '';
        $content .= '# '. $this->contentCreator->getSubject();
        $content .= "\r\n\r\n";
        $content .= $userMailSuccessFull 
            ? $this->contentCreator->getSuccessMessage() 
            : $this->contentCreator->getFailedMessage();
        $content .= "\r\n\r\n";
        $content .= $this->contentCreator->getDataTable();
    }


    
}