<?php

namespace Hcode\Services;

class PageAdmin extends Page
{
    public function __construct($opts = [])
    {
        parent::__construct($opts, CONF_VIEW_DIR_ADMIN);
    }
}
