
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number')->nullable();
            }

            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }

            if (!Schema::hasColumn('users', 'iban')) {
                $table->string('iban')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // لا نحذف الأعمدة حتى لا نحذف بيانات موجودة مسبقًا.
    }
};

