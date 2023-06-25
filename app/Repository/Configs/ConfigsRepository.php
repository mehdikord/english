<?php
namespace App\Repository\Configs;




use App\Interfaces\Configs\ConfigsInterface;
use App\Models\Config;

class ConfigsRepository implements ConfigsInterface
{
    public function index()
    {
        return response_success(Config::all());
    }



    public function update($request,$item)
    {
        $item->update([
            'conf_val' => $request->conf_val,
            'description' => $request->description,
        ]);
        return response_success($item);
    }

    public function default()
    {
        foreach (Config::all() as $config){

            $config->delete();
        }
        foreach ($this->configs() as $config){

            Config::create($config);

        }
        return response_success(true,'done');
    }


    private function configs(){
        return [
            [
                'conf_key' => 'life_price',
                'conf_val' => '1500',
                'description' => 'The price of each user life to buy',
            ],
            [
                'conf_key' => 'version',
                'conf_val' => '1',
                'description' => 'Application version number',
            ]

        ];



    }


}
