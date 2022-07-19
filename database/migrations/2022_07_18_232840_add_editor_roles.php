<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = \App\Models\Type::query()
                                    ->whereNull('type_id')
                                    ->get();

        $types->each(function($type){
            \App\Models\Role::create([
                'name' => $type->name . ' Editor',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Role::where('name', 'LIKE', '% Editor%')->delete();
    }
};
