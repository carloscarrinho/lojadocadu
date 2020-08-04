<?php

namespace Hcode\Services;

use Rain\Tpl;

/**
 * Page Class | Mount a page
 */
class Page
{
    private $tpl;
    private $options = [];
    private $defaults = [
        "header" => true,
        "footer" => true,
        "data" => [],
    ];

    /**
     * Builds view template
     *
     * @param  array $opts
     * @return void
     */
    public function __construct(array $opts = [], string $tpl_dir = CONF_VIEW_DIR_STORE)
    {
        $this->options = array_merge($this->defaults, $opts);
        Tpl::configure([
            "tpl_dir" => $_SERVER['DOCUMENT_ROOT'] . $tpl_dir,
            "cache_dir" => $_SERVER['DOCUMENT_ROOT'] . CONF_VIEW_DIR_CACHE,
            "debug" => false,
        ]);

        $this->tpl = new Tpl();
        $this->setData($this->options['data']);
        if ($this->options['header'] === true) {
            $this->tpl->draw("header");
        }

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
        if ($this->options['footer'] === true) {
            $this->tpl->draw("footer");
        }

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
