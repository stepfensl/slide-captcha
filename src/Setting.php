<?php

namespace Dact\Admin\SlideCaptcha;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->radio('enbale', '状态')->options(['关闭', '开启'])->default(1)->required();
    }
}
