<?php

namespace Sb\Phalcon\Helpers\Analytics;

class RatingMail
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

        return
        "<script>\n" +
        "   var RatingMailImage = new Image();\n" +
        "   RatingMailImage.src = \"//top-fwz1.mail.ru/counter?id='{$this->id}';t=464;l=1\";\n" +
        "</script>\n";
    }
} 