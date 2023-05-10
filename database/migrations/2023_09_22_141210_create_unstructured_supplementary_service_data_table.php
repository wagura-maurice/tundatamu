<?php

use App\Models\UnstructuredSupplementaryServiceData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnstructuredSupplementaryServiceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unstructured_supplementary_service_data', function (Blueprint $table) {
            $table->id();
            $table->string('sessionId'); // ->unique();
            $table->string('phoneNumber');
            $table->string('serviceCode');
            $table->string('networkCode')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
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
        Schema::dropIfExists('unstructured_supplementary_service_data');
    }
}
