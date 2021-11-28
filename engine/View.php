<?php

namespace engine;

class View
{
    private string $tpl;
    private string $view;
    private array $data;
    private static array $meta = ['title' => '', 'description' => ''];

    public function __construct(string $tpl, string $view, array $data)
    {
        $this->tpl = $tpl;
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        if (!empty($this->data)) {
            extract($this->data);
        }

        ob_start();
        include_once ROOT . '/app/views/' . $this->view . '.php';
        $_CONTENT = ob_get_clean();

        include_once ROOT . '/app/views/' . $this->tpl . '.php';
    }

    /**
     * Устанавливает мета-данные (title|description)
     * @param string $title
     * @param string $description
     */
    public static function setMeta(string $title = '', string $description = '')
    {
        self::$meta = [
            'title' => $title,
            'description' => $description
        ];
    }

    public static function getTitle(): string
    {
        return self::$meta['title'];
    }

    public static function getDescription(): string
    {
        return self::$meta['description'];
    }

}