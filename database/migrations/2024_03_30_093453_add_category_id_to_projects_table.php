<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //definizione colonna
            //$table->unsignedBigInteger('category_id')->nullable()->after('id');
            //definizione chiave esterna
            //$table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();

            //un aiuto di LARAVEL se si segue le convenzioni 
            //$table->foreignId('category_id')->after('id')->nullable()->constrained()->nullOnDelete();

            $table->foreignIdFor(Category::class)->after('id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //rimuovo la relazione
            //$table->dropForeign('projects_category_id_foreign');
            $table->dropForeignIdFor(Category::class);

            //rimuovo la colonna 
            $table->dropColumn('category_id');
        });
    }
};
