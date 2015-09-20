<?php

namespace Sb\Phalcon\Helpers\Analytics;

class LiveInternet
{
    private $id = null;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        if (!$this->id) {
            return '';
        }

        return '
            <script>
                var LiveInternetImage = new Image();
                LiveInternetImage.src = "//counter.yadro.ru/hit?t14.10;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s" + screen.width+"*" + screen.height+"*" + (screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) + ";h" + escape(document.title.substring(0,80)) + ";" + Math.random();
            </script>
        ';
    }
} 