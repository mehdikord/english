<?php
namespace App\Interfaces\Episodes;

interface EpisodesInterface
{

    public function index();

    public function store($request);

    public function update($request,$item);

    public function delete($item);

    public function activation($item);

    //Public ( no auth) functions
    public function public_index();

    public function download($item);

    public function user_index();

    public function user_active();

    public function user_buy($item);

    public function user_set_active($item);
    public function user_set_done($item);


}
