<?php
namespace App\Interfaces\Episodes;

interface EpisodesInterface
{

    public function index();

    public function store($request);

    public function update($request,$item);

    public function delete($item);

    public function activation($item);


}
