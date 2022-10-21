<?php

namespace Devmaurice\Kesms\Contracts;

interface Gateway
{
    public function send($message, $phones = []);

    public function balance();
}
