<?php

class Route extends Prefab
{
    protected $f3;
    public function __construct()
    {
        $this->f3 = f3();
    }
    public function uri()
    {
        return $this->f3['URI'];
    }
    public function type()
    {
        return $this->f3['VERB'];
    }
    public function has($route)
    {
        if (Str::contains($route, '/')) {
            return array_key_exists($route, $this->getRoutes());
        }

        return $this->hasNamedRoute($route);
    }
    public function current()
    {
        return $this->f3['PATH'];
    }
    public function is($route)
    {
        return Str::contains($this->current(), $route);
    }
    public function currentRouteName()
    {
        return $this->getRoutes()[$this->current()][0][$this->type()][3];
    }
    public function getRouteName($route)
    {
        $response = null;
        foreach ($this->getNamedRoutes() as $name => $url) {
            if ($url == $route) {
                $response[] = $name;
            }
        }
        return $response;
        //return array_search($this->getNamedRoutes(), $route);
    }
    public function hasNamedRoute($route)
    {
        return array_key_exists($route, $this->getNamedRoutes());
    }
    public function getNamedRoutes()
    {
        return $this->f3['ALIASES'];
    }
    public function getRoutes()
    {
        return $this->f3['ROUTES'];
    }
    public function getUrl($alias)
    {
        return $this->has($alias) ? $this->getNamedRoutes()[$alias] : null;
    }
    public function hasParameter($parameter)
    {
        return (bool) $this->parameter($parameter);
    }
    public function parameters()
    {
        return $this->f3[$this->type()];
    }
    public function parameter($parameter)
    {
        return $this->f3[$this->type().'.'.$parameter];
    }
    public function isApi($url = null)
    {
        $path = $url?:$this->current();
        if (is_string($path)) {
            return explode('/', $path)[1] === 'api';
        }
        return false;
    }
}