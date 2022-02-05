<?php namespace Ske\Cgi;

class Website {
    public function __construct(protected Server $server, protected Domain $domain) {}
    
    public function getServer(): Server {
        return $this->server;
    }
    
    public function getDomain(): Domain {
        return $this->domain;
    }
}
