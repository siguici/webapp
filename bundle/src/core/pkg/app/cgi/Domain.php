<?php namespace Ske\Cgi;

class Domain {
    public function __construct(protected Website $website, string $name, string $root) {
        $this->setName($name);
        $this->setRoot($root);
    }
    
    protected string $name;
    
    public function setName(string $name): void {
        $this->name = $name;
        $this->server->setDomain($name, $this->getRoot());
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    protected string $root;
    
    public function setRoot(string $root): void {
        $this->root = $root;
    }
    
    public function getRoot(): string {
        return $this->root;
    }
    
    protected array $subdomains = [];
    
    public function setSubdomain(string $name, string $root): Domain {
        $name = strtolower($name);
        if (isset($this->subdomains[$name])) {
            $domain = $this->subdomains[$name];
            $domain->setRoot($root);
        }
        else
            $domain = $this->subdomains[$name] = new Subdomain($this, $name, $root);
        return $domain;
    }
    
    public function getSubdomain(string $name): ?Subdomain {
        return $this->subdomains[$name] ?? null;
    }
    
    public function issetSubdomain(string $name): bool {
        return isset($this->subdomains[$name]);
    }
    
    public function unsetSubdomain(string $name): void {
        unset($this->subdomains[$name]);
    }
}
