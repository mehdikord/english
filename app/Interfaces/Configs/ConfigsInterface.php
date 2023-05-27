<?php
namespace App\Interfaces\Configs;

interface ConfigsInterface
{
    public function index();

    public function update($request,$item);
    public function default();


}
