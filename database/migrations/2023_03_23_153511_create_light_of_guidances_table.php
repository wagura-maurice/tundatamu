<?php

use App\Models\LightOfGuidance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLightOfGuidancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('light_of_guidances', function (Blueprint $table) {
            $table->id();
            $table->string('_class');
            $table->text('description');
            $table->integer('_status')->default(LightOfGuidance::PENDING);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('light_of_guidances');
    }
}
