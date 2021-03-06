<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGerencianetPixTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('gerencianet_pix', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('subscription_invoice_id');
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('total', 22, 2);
            $table->string('gerencianet_txid');
            $table->string('gerencianet_e2eid')->nullable();
            $table->text('gerencianet_qrcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('gerencianet_pix');
    }

}
