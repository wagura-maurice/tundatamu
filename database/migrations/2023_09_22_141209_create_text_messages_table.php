<?php

use App\Models\TextMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_messages', function (Blueprint $table) {
            $table->id();
            $table->string('_pid')->nullable()->unique();
            $table->foreignId('category_id')->unsigned()->constrained('communication_categories')->onDelete('cascade');
            $table->foreignId('bulk_text_message_id')->nullable()->constrained('bulk_text_messages')->onDelete('cascade');
            $table->text('content');
            $table->string('telephone');
            $table->string('transaction_id')->nullable()->unique();
            $table->decimal('transaction_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('text_messages');
    }
}
