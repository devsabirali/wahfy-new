<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blog_tag', function (Blueprint $table) {
            // Drop the incorrect column if it exists
            if (Schema::hasColumn('blog_tag', 'blog_tag_id')) {
                $table->dropColumn('blog_tag_id');
            }

            // Add the correct column if it doesn't exist
            if (!Schema::hasColumn('blog_tag', 'tag_id')) {
                $table->unsignedBigInteger('tag_id');
                $table->foreign('tag_id')->references('id')->on('blog_tags')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('blog_tag', function (Blueprint $table) {
            // Drop the correct column
            if (Schema::hasColumn('blog_tag', 'tag_id')) {
                $table->dropForeign(['tag_id']);
                $table->dropColumn('tag_id');
            }

            // Add back the incorrect column
            if (!Schema::hasColumn('blog_tag', 'blog_tag_id')) {
                $table->unsignedBigInteger('blog_tag_id');
                $table->foreign('blog_tag_id')->references('id')->on('blog_tags')->onDelete('cascade');
            }
        });
    }
};
