<?php

namespace Hcode;

use Rain\Tpl;

/**
 * Page Class | Mount a page
 */
class Page
{
    private $tpl;
    private $options = [];
    private $defaults = ["data" => []];

    /**
     * Builds view template
     *
     * @param  array $opts
     * @return void
     */
    public function __construct(array $opts = [])
    {
        $this->options = array_merge($this->defaults, $opts);

        Tpl::configure([
            "tpl_dir" => $_SERVER['DOCUMENT_ROOT'] . "/views/",
            "cache_dir" => $_SERVER['DOCUMENT_ROOT'] . "/views-cache/",
            "debug" => false,
        ]);

        $this->tpl = new Tpl();
        $this->setData($this->options['data']);
        $this->tpl->draw("header");
    }

    /**
     * Sets a template
     *
     * @param  string $name
     * @param  array $data
     * @param  bool $returnHTML
     * @return void
     */
    public function setTpl(string $name, array $data = [], bool $returnHTML = false)
    {
        $this->setData($data);
        return $this->tpl->draw($name, $returnHTML);
    }

    /**
     * Implements footer template
     *
     * @return void
     */
    public function __destruct()
    {
        $this->tpl->draw("footer");
    }

    /**
     * Defines data to template
     *
     * @param  array $data
     * @return void
     */
    private function setData(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }
}
