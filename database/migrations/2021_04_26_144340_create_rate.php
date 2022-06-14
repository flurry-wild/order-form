<?php

use App\Domain\ValueObject\Rate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('price');
            $table->string('days')->nullable();
            $table->timestamps();
        });

        Rate::create([
            'name' => 'Классический',
            'price' => 2000,
            'days' => json_encode([0,1])
        ]);
        Rate::create([
            'name' => 'Русское ассорти',
            'price' => 1500,
            'days' => json_encode([0, 1, 2, 3, 4, 5, 6])
        ]);
        Rate::create([
            'name' => 'Мексиканское буррито',
            'price' => 350,
            'days' => json_encode([5, 6])
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
