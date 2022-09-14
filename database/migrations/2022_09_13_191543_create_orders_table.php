<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $status = [
            "CREATED",
            "PAYED",
            "REJECTED"
        ];

        Schema::create('orders', function (Blueprint $table) use ($status) {
            $table->id();
            $table->string('customer_name',80)->comment("name of customer");
            $table->string('customer_email',120)->comment("email of customer");
            $table->string('customer_mobile',40)->comment("mobile number of customer");
            $table->string('customer_document_number',20)->comment("document number of customer");
            $table->string('customer_document_type',5)->comment("document type of customer");
            $table->enum('status',$status)->comment("status of order");
            $table->foreignId('product_id')->constrained();
            $table->string('identifier_code',10)->unique()->comment("unique code for identify an order");
            $table->double('total',8,2)->comment("order's price");
            $table->string('payment_url',191)->nullable()->comment("url for pay the order");
            $table->string('payment_session',191)->nullable()->comment("session id to pay for the order");
            $table->timestamp('payment_date')->nullable()->comment("date of payment");
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
        Schema::dropIfExists('orders');
    }
}
