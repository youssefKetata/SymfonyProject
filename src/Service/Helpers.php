<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class Helpers
{
    private $lan;
    public function __construct(private LoggerInterface $logger)
    {

    }

    public function sayH(): String{
        $this->logger->info('youu');
        return 'you';
    }

}