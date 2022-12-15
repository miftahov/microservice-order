<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('orders');
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();
            //статусы
            $table->string('status')->nullable();
            $table->boolean('orderEdited')->nullable();
            //данные
            $table->integer('price')->nullable();
            $table->integer('discount')->nullable();
            $table->string('delivery')->nullable();
            $table->string('phone')->nullable();
            $table->text('buyerComment')->nullable();
            $table->json('goods')->nullable();
            $table->json('positions')->nullable();
            $table->json('moreInfo')->nullable();
            //связи
            $table->uuid('filialUuid')->nullable();
            $table->uuid('paymentUuid')->nullable();
            $table->uuid('customer')->nullable();
            $table->uuid('userUuid')->nullable();
            $table->uuid('deliveryUuid')->nullable();
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
