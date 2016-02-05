<?php

namespace Sb\Phalcon\Helpers\Analytics;

class GoogleAnalytics
{
    private $id = null;
    private $userId = null;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        if (!$this->id) {
            return '';
        }

        $result = "
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');";

        if ($this->userId) {
            $result .= "
            ga('create', '{$this->id}', {'userId': '{$this->userId}'});
            ";
        } else {
            $result .= "
            ga('create', '{$this->id}');
            ";
        }

        $result .= "
            ga('require', 'displayfeatures');
            ga('send', 'pageview');
        </script>
        ";

        return $result;
    }
} 