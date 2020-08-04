<?php
class Container extends Template {
    public function __construct(Header $header, Footer $footer, $content)
    {
        $this->file = TEMPLATE_PATH.'/container.tpl';
        if (empty($header)){
            throw new Exception('No Header provided');
        }
        if (empty($content)){
            throw new Exception('No Content provided');
        }
        if (empty($footer)){
            throw new Exception('No Footer provided');
        }
        $this->values['header']=$header->output();
        $this->values['content']=$content->output();
        $this->values['footer']=$footer->output();
    }
}