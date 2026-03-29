<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->string('video_platform', 32)->nullable()->after('video_url');
            $table->string('video_external_id', 128)->nullable()->after('video_platform');
            $table->text('video_embed_url')->nullable()->after('video_external_id');
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE gallery_items MODIFY video_url TEXT NULL');
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE gallery_items MODIFY video_url VARCHAR(255) NULL');
        }

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropColumn(['video_platform', 'video_external_id', 'video_embed_url']);
        });
    }
};
