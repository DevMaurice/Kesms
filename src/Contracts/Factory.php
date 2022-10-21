<?php

namespace Devmaurice\Kesms\Contracts;

interface Factory
{
    /**
     * Get a sms gateway instance by name.
     *
     * @param  string|null  $name
     * @return \Devmaurice\Kesms\Repository
     */
    public function gateway($name = null);
}
