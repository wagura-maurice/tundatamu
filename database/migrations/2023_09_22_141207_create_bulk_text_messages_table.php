<?php

use App\Models\TextMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkTextMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_text_messages', function (Blueprint $table) {
            $table->id();
            $table->string('_pid')->unique();
            $table->foreignId('category_id')->unsigned()->constrained('communication_categories')->onDelete('cascade');
            $table->text('content');
            $table->json('contacts');
            $table->integer('_status')->default(TextMessage::PENDING);
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
        Schema::dropIfExists('bulk_text_messages');
    }
}
