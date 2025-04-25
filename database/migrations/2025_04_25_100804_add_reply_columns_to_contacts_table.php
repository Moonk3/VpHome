<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('contacts', function (Blueprint $table) {
        // $table->boolean('is_replied')->default(false); // ❌ Bỏ dòng này vì đã tồn tại
        $table->text('reply_message')->nullable(); // ✅ Giữ lại dòng này
    });
}

public function down()
{
    Schema::table('contacts', function (Blueprint $table) {
        // $table->dropColumn('is_replied'); // ❌ Bỏ dòng này luôn nếu không cần rollback đầy đủ
        $table->dropColumn('reply_message'); // ✅ Giữ dòng này
    });
}


};
