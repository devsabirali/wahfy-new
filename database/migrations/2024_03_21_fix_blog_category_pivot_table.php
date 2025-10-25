<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blog_category', function (Blueprint $table) {
            // Drop the incorrect column if it exists
            if (Schema::hasColumn('blog_category', 'blog_category_id')) {
                $table->dropColumn('blog_category_id');
            }

            // Add the correct column if it doesn't exist
            if (!Schema::hasColumn('blog_category', 'category_id')) {
                $table->unsignedBigInteger('category_id');
                $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('blog_category', function (Blueprint $table) {
            // Drop the correct column
            if (Schema::hasColumn('blog_category', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            // Add back the incorrect column
            if (!Schema::hasColumn('blog_category', 'blog_category_id')) {
                $table->unsignedBigInteger('blog_category_id');
                $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            }
        });
    }
};
