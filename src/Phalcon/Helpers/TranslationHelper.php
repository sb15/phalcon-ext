<?php

namespace Sb\Phalcon\Helpers;

class TranslationHelper
{
    const SERVICE_NAME = 'translation-helper';

    private $di = null;
    private $moduleName = null;
    private $lang = 'en';

    private $translator = null;

    public function __construct($di, $moduleName = '')
    {
        $this->di = $di;
        $this->moduleName = $moduleName;
    }

    public function setLang($lang)
    {
        if (strpos($lang, "-") !== false) {
            $temp = explode("-", $lang);
            $lang = $temp[0];
        }

        if ($lang == 'ru') {
            setlocale(LC_ALL, 'ru_RU.utf-8');
        }

        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
    }

    private function getMessagesDir()
    {
        $result = APPLICATION_PATH;
        if ($this->moduleName) {
            $result .= '/' . $this->moduleName;
        }
        $result .= '/messages/';
        return $result;
    }

    public function getTranslation()
    {
        if (!$this->translator) {
            $language = $this->getLang();

            if (file_exists($this->getMessagesDir() . $language . ".php")) {
                $messages = include $this->getMessagesDir() . $language . ".php";
            } else {
                $messages = include $this->getMessagesDir() . "en.php";
            }

            $this->translator = new \Sb\Phalcon\Translate\Adapter\Translate(
                array(
                    "content" => $messages
                )
            );
        }

        return $this->translator;
    }

}