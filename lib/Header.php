<?php
class Header extends Template {
    public function __construct()
    {
        $this->file = TEMPLATE_PATH.'/header.tpl';
        $this->values['logo_atlas'] = TEMPLATE_PATH.'/img/logo-atlas.png';
        $this->values['titulo'] = 'Recordatorio';
    }
}