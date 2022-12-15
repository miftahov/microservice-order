<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('userUuid');
            $table->string('phone');
            $table->boolean('orderEdited');
            $table->uuid('deliveryUuid');
            $table->text('buyerComment');
            $table->json('positions');
            $table->json('moreInfo');
            $table->uuid('filialUuid');
            $table->uuid('paymentUuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('userUuid');
            $table->dropColumn('phone');
            $table->dropColumn('orderEdited');
            $table->dropColumn('deliveryUuid');
            $table->dropColumn('buyerComment');
            $table->dropColumn('positions');
            $table->dropColumn('moreInfo');
            $table->dropColumn('filialUuid');
            $table->dropColumn('paymentUuid');
        });
    }
}
