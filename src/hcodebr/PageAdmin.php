<?php

namespace Hcode;

use Hcode\Page;

class PageAdmin extends Page
{
    public function __construct($opts = [])
    {
        parent::__construct($opts, "/views/admin/");
    }
}
