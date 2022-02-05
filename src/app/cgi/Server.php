<?php namespace Ske\Cgi;

use Ske\IO\{Input_Interface, Output_Interface};

class Server {
    public function __construct(string $name,string $host, int $port, string $root){
        $this->setDomain();
    }
    
    protected array $hosts = [];
    
    public function setHosts(array $hosts): void {
        foreach ($hosts as $host)
            $this->setHost($host);
    }
    
    public function setHost(string $host): void {
        if (!in_array($host, $this->hosts))
            $this->hosts[] = $host;
    }
    
    public function getHosts(): array {
        return $this->hosts;
    }

    protected array $ports = [];
    
    public function setPorts(array $ports): void {
        foreach ($ports as $port)
            $this->setPort($port);
    }
    
    public function setPort(string $port): void {
        if (!in_array($port, $this->ports))
            $this->ports[] = $port;
    }
    
    public function getPorts(): array {
        return $this->ports;
    }
    
    protected array $websites = [];
    
    public function addWebsite(string $name, string $root): Website {
        $domain = new Domain($name, $root);
        
        return $domain;
    }
    
    public function getDomain(string $name): ?Subdomain {
        return $this->domains[$name] ?? null;
    }
    
    public function issetDomain(string $name): bool {
        return isset($this->domains[$name]);
    }
    
    public function unsetDomain(string $name): void {
        unset($this->domains[$name]);
    }

    public function process(array $env, Input_Interface $input, Output_Interface $output) {
        $output->write('Welcome to SIKessEm!');
    }
}
