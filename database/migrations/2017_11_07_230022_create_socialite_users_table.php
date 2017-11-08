<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialite_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('platform', [
                'web',
                'app',
            ]);
            $table->enum('provider', [
                'facebook',
                'github',
                'google',
                'linkedin',
                'weibo',
                'qq',
                'wechat',
                'wechat_open',
                'douban',
            ]);
            $table->string('open_id');
            $table->string('nickname')->default('');
            $table->string('name')->default('');
            $table->string('email')->default('');
            $table->string('avatar')->default('');
            $table->json('token');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index([
                'user_id',
                'platform',
                'provider',
            ], 'socialite_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialite_users');
    }
}
