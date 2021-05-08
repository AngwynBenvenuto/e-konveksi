<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('province', function (Blueprint $table) {
        //     $table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
        // });
        // Schema::table('city', function (Blueprint $table) {
        //     $table->foreign('province_id')->references('id')->on('province')->onDelete('cascade');
        // });
        // Schema::table('districts', function (Blueprint $table) {
        //     $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
        // });
        Schema::table('project', function (Blueprint $table) {
            $table->foreign('ikm_id')->references('id')->on('ikm')->onDelete('cascade');
        });
        Schema::table('project_image', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
        });
        Schema::table('project_ukuran', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
            $table->foreign('ukuran_id')->references('id')->on('ukuran')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');
            $table->foreign('ikm_id')->references('id')->on('ikm')->onDelete('cascade');
        });
        Schema::table('users_password_resets', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        //Schema::table('penjahit', function (Blueprint $table) {
            //$table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
            //$table->foreign('province_id')->references('id')->on('province')->onDelete('cascade');
            //$table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
            //$table->foreign('districts_id')->references('id')->on('districts')->onDelete('cascade');
        //});
        //Schema::table('penjahit_address', function (Blueprint $table) {
            //$table->foreign('penjahit_id')->references('id')->on('penjahit')->onDelete('cascade');
            //$table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
            //$table->foreign('province_id')->references('id')->on('province')->onDelete('cascade');
            //$table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
            //$table->foreign('districts_id')->references('id')->on('districts')->onDelete('cascade');
        //});
        Schema::table('penjahit_verify', function (Blueprint $table) {
            $table->foreign('penjahit_id')->references('id')->on('penjahit')->onDelete('cascade');
        });
        Schema::table('penjahit_password_resets', function (Blueprint $table) {
            $table->foreign('penjahit_id')->references('id')->on('penjahit')->onDelete('cascade');
        });
        //$table->foreign('country_id')->references('id')->on('country')->onDelete('cascade');
        Schema::table('ikm', function (Blueprint $table) {
            //$table->foreign('province_id')->references('id')->on('province')->onDelete('cascade');
            //$table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
            //$table->foreign('districts_id')->references('id')->on('districts')->onDelete('cascade');
        });
        Schema::table('chatting', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
        });
        // Schema::table('offers', function (Blueprint $table) {
        //     $table->foreign('ikm_id')->references('id')->on('ikm')->onDelete('cascade');
        //     $table->foreign('penjahit_id')->references('id')->on('penjahit')->onDelete('cascade');
        //     $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
        // });
        // Schema::table('transaction', function (Blueprint $table) {
        //     $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('province', function (Blueprint $table) {
        //     $table->dropForeign('province_country_id_foreign');
        // });
       
        // Schema::table('city', function (Blueprint $table) {
        //     $table->dropForeign('city_province_id_foreign');
        // });
        
        // Schema::table('districts', function (Blueprint $table) {
        //     $table->dropForeign('districts_city_id_foreign');
        // });
        
        Schema::table('project', function (Blueprint $table) {
            $table->dropForeign('project_ikm_id_foreign');
        });

        Schema::table('project_image', function (Blueprint $table) {
            $table->dropForeign('project_image_project_id_foreign');
        });

        Schema::table('project_ukuran', function (Blueprint $table) {
            $table->dropForeign('project_ukuran_project_id_foreign');
            $table->dropForeign('project_ukuran_ukuran_id_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
            $table->dropForeign('users_ikm_id_foreign');
        });
        
        Schema::table('users_password_resets', function (Blueprint $table) {
            $table->dropForeign('users_password_resets_user_id_foreign');
        });
        
        Schema::table('ikm', function (Blueprint $table) {
            //$table->dropForeign('ikm_country_id_foreign');
            $table->dropForeign('ikm_province_id_foreign');
            $table->dropForeign('ikm_city_id_foreign');
            $table->dropForeign('ikm_districts_id_foreign');
        });

        Schema::table('penjahit', function (Blueprint $table) {
            //$table->dropForeign('penjahit_country_id_foreign');
            $table->dropForeign('penjahit_province_id_foreign');
            $table->dropForeign('penjahit_city_id_foreign');
            $table->dropForeign('penjahit_districts_id_foreign');
        });

        Schema::table('penjahit_address', function (Blueprint $table) {
            $table->dropForeign('penjahit_address_penjahit_id_foreign');
            //$table->dropForeign('penjahit_address_country_id_foreign');
            $table->dropForeign('penjahit_address_province_id_foreign');
            $table->dropForeign('penjahit_address_city_id_foreign');
            $table->dropForeign('penjahit_address_districts_id_foreign');
        });

        Schema::table('penjahit_verify', function (Blueprint $table) {
            $table->dropForeign('penjahit_verify_penjahit_id_foreign');
        });
        
        Schema::table('penjahit_password_resets', function (Blueprint $table) {
            $table->dropForeign('penjahit_password_resets_penjahit_id_foreign');
        });
        
        Schema::table('chatting', function (Blueprint $table) {
            $table->dropForeign('chatting_project_id_foreign');
        });
        
        Schema::table('offers', function (Blueprint $table) {
            $table->dropForeign('offers_ikm_id_foreign');
            $table->dropForeign('offers_penjahit_id_foreign');
            $table->dropForeign('offers_project_id_foreign');
        });
        
        Schema::table('transaction', function (Blueprint $table) {
            $table->dropForeign('transaction_project_id_foreign');
        });

    }
}
