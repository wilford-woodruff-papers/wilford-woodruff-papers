<?php

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
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
        try {
            Schema::table('subjects', function (Blueprint $table) {
                $table->string('last_name')->after('name')->index()->nullable();
                $table->string('first_name')->after('name')->index()->nullable();
            });
            $people = Subject::query()
                                ->whereHas('category', function (Builder $query) {
                                    $query->where('name', 'People');
                                })
                                ->get();
            $people->each(function($person){
                $person->calculateNames();
                $person->save();
            });

        } catch(Exception $exception){
            logger()->error($exception->getMessage());
            $this->down();
            throw $exception;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
    }
};
