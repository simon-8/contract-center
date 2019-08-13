<?php

namespace App\Console\Commands;

use App\Models\ExpressFee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class makeExpressArea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'express:area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成快递省份';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filePath = public_path('admin/js/plugins/w-picker/city-data/province.js');
        $data = File::get($filePath);
        $data = json_decode($data);
        foreach ($data as $k => $v) {
            ExpressFee::create([
                'id' => $v->value,
                'name' => $v->label,
                'amount' => '0',
            ]);
        }
    }
}
