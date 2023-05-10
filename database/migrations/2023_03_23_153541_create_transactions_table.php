<?php

use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('_pid')->unique(); // unique id, to be used in callback query's.
            $table->string('party_a'); // tenant phone number.
            $table->string('party_b'); // accounting book number affected/concerned.
            $table->string('account_reference'); // invoice _PID's
            $table->integer('transaction_category'); // invoice or booking payment
            $table->integer('transaction_type'); // debit or credit
            $table->integer('transaction_channel'); // C2B, B2C or B2B
            $table->integer('transaction_aggregator'); // m-pesa, equity bank kenya, co-operative bank of kenya, KCB bank kenya
            $table->string('transaction_id')->unique();
            $table->decimal('transaction_amount', 10, 2); // $Amount
            $table->string('transaction_code')->nullable()->unique(); // Nullable on transaction initialization and filled in callback event.
            $table->timestamp('transaction_timestamp'); // a transaction initialization time stamp.
            $table->text('transaction_details'); // transaction remark's. e.t.c
            $table->json('_feedback'); // full json response string, as from the processor. json_encode($response)
            $table->integer('_status')->default(Transaction::PENDING);
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
        Schema::dropIfExists('transactions');
    }
}
