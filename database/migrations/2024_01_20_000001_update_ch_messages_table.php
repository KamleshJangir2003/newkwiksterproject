<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateChMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            // Add group_id column if it doesn't exist
            if (!Schema::hasColumn('ch_messages', 'group_id')) {
                $table->bigInteger('group_id')->nullable()->after('to_id');
            }
            
            // Add reply_id column if it doesn't exist
            if (!Schema::hasColumn('ch_messages', 'reply_id')) {
                $table->bigInteger('reply_id')->nullable()->after('body');
            }
            
            // Add forward column if it doesn't exist
            if (!Schema::hasColumn('ch_messages', 'forward')) {
                $table->boolean('forward')->default(false)->after('reply_id');
            }
            
            // Add deleted column if it doesn't exist
            if (!Schema::hasColumn('ch_messages', 'deleted')) {
                $table->boolean('deleted')->default(false)->after('forward');
            }
            
            // Modify seen column to support JSON for group messages
            if (Schema::hasColumn('ch_messages', 'seen')) {
                $table->json('seen')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->dropColumn(['group_id', 'reply_id', 'forward', 'deleted']);
            $table->boolean('seen')->default(false)->change();
        });
    }
}