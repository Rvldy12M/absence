<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'class')) {
                $table->dropColumn('class');
            }
    
            $table->unsignedBigInteger('class_id')->nullable()->after('email');
            $table->foreign('class_id')->references('id')->on('classrooms')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
            $table->string('class')->nullable();
        });
    }
    };
