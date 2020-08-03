<?php

class MasterLayout extends Template {
    var $container;
    public function __construct(Container $container)
    {
        $this->file = TEMPLATE_PATH.'/master.tpl';
        $this->values['content']=$container->output();
    }
}