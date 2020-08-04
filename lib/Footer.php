<?php
class Footer extends Template {
    public function __construct()
    {
        $this->file = TEMPLATE_PATH . '/footer.tpl';
        $this->values['f_logo'] = TEMPLATE_PATH . '/img/logo.png';
        $this->values['f_titulo'] = 'ENDE TRANSMISION&nbsp;S.A.';
        $this->values['f_subtitulo'] = 'Empresa regulada por la Autoridad de Fiscalización y Control Social de Electricidad';
        $this->values['f_link_logo'] = 'http://www.endetransmision.bo';
        $this->values['f_email'] = 'info@endetransmision.bo';
        $this->values['f_direccion'] = 'Calle Walter Galindo N S-3643';
        $this->values['f_link_logo_ln'] = 'https://www.linkedin.com/company/ende-transmision';
        $this->values['f_logo_ln'] = TEMPLATE_PATH . '/img/ln.png';
        $this->values['f_link_logo_fb'] = 'https://www.facebook.com/endetransmision';
        $this->values['f_logo_fb'] = TEMPLATE_PATH . '/img/fb.png';
        $this->values['f_link_logo_tt'] = 'https://twitter.com/EndeTransmision';
        $this->values['f_logo_tt'] = TEMPLATE_PATH . '/img/tt.png';
        $this->values['f_link_web'] = 'http://www.endetransmision.bo';
        $this->values['f_web'] = 'www.endetransmision.bo';

    }
}