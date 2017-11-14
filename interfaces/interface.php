<?php

interface AInterface{
    public function save(array $data);
}

class A implements AInterface, Countable {
    public function save(array $t){
        return 'foo';
    }
    public function log(){

    }
    public function count(){
        return 10;
    }
}

echo (new A())->save([]);
echo (new A())->count();

