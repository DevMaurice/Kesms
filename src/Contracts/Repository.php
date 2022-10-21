<?php

namespace Devmaurice\Kesms\Contracts;

interface Repository {

    public function send($message, $phones = []);

    public function sendOne($message, $phones = null);

    public function sendMany($message, $phones = []);

    public function getBalance();

    public function getGateway();

}
