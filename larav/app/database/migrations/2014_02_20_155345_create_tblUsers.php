<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tblUsers', function($table) {
            $table->increments('id');
            $table->string('userEmail');
            $table->string('userPassword');
            $table->string('userFirstName');
            $table->string('userLastName');
            $table->string('userAddress');
            $table->string('userPhone');
            $table->string('userIdentify');
            $table->integer('userPoint', 20);
            $table->string('userTime');
            $table->string('verify');
            $table->integer('status');
        });
        Schema::create('tblCategoryProduct', function($table) {
            $table->increments('id');
            $table->string('cateName');
            $table->integer('cateParent');
            $table->string('cateSlug');
            $table->string('cateTime');
            $table->integer('status');
        });
        Schema::create('tblProduct', function($table) {
            $table->increments('id');
            $table->integer('cateID');
            $table->string('productName');
            $table->string('productUrlImage');
            $table->string('productDescription');
            $table->integer('productPrice', 20);
            $table->integer('productPromotion', 20);
            $table->string('productUrlDemo');
            $table->string('productSlug');
            $table->string('productVersion');
            $table->string('productTimeUpdateVersion');
            $table->string('productTime');
            $table->integer('status');
        });
        Schema::create('tblOrder', function($table) {
            $table->increments('id');
            $table->integer('userID');
            $table->integer('productID');
            $table->integer('orderAmount', 20);
            $table->string('orderTypePay');
            $table->string('orderStatusPay');
            $table->string('orderTime');
            $table->integer('status');
        });
        Schema::create('tblHistory', function($table) {
            $table->increments('id');
            $table->integer('userID');
            $table->string('historyContent');
            $table->string('historyTime');
            $table->integer('status');
        });
        //tblServices
        Schema::create('tblServices', function($table) {
            $table->increments('id');
            $table->string('orderCode');
            $table->string('servicesName');
            $table->string('servicesContent');
            $table->integer('servicesPrices', 20);
            $table->integer('servicesPromotion', 20);
            $table->string('servicesSlug');
            $table->integer('servicesType');
            $table->integer('viewType');
            $table->string('servicesTime');
            $table->integer('status');
        });
        //tblServicesOrder
        Schema::create('tblServicesOrder', function($table) {
            $table->increments('id');
            $table->string('orderCode');
            $table->integer('servicesID');
            $table->integer('orderID', null);
            $table->string('userEmail');
            $table->string('dateExp');
            $table->integer('servicesorderAmount', 20);
            $table->string('servicesSlug');
            $table->integer('servicesorderTypePay');
            $table->integer('servicesorderStatusPay');
            $table->string('servicesorderTime');
            $table->integer('status');
        });
        //tblStatistic bang thong ke
        Schema::create('tblStatistic', function($table) {
            $table->increments('id');
            $table->string('statisticFrom');
            $table->string('statisticTo');
            $table->integer('statisticMoneyProduct', 20);
            $table->integer('statisticMoneyServices', 20);
            $table->integer('statisticNumberNewUser');
            $table->integer('statisticNumberStopUser');
            $table->integer('statisticNumberTotalUser');
            $table->string('statisticTime');
            $table->integer('status');
        });
        //tblMenu Bang luu lai menu
        Schema::create('tblMenu', function($table) {
            $table->increments('id');
            $table->string('menuName');
            $table->string('menuURL');
            $table->integer('menuParent');
            $table->integer('menuPosition');
            $table->string('menuTime');
            $table->integer('status');
        });
        //tblPage bang luu lai cac page
        Schema::create('tblPage', function($table) {
            $table->increments('id');
            $table->string('pageName');
            $table->string('pageContent');
            $table->string('pageTag');
            $table->string('pageSlug');
            $table->string('pageTime');
            $table->integer('status');
        });
        //tblCateNews Bang luu lai category cua Tin Tuc
        Schema::create('tblCateNews', function($table) {
            $table->increments('id');
            $table->string('catenewsName');
            $table->integer('catenewsParent');
            $table->string('catenewsSlug');
            $table->string('catenewsTime');
            $table->integer('status');
        });
        //tblNews Bang Tin Tuc --- Dung de dua cac tin tuc o ngoai va tin tu admin cho user --- dung de SEO
        Schema::create('tblNews', function($table) {
            $table->increments('id');
            $table->integer('catenewsID');
            $table->string('newsName');
            $table->string('newsDescription');
            $table->string('newsContent');
            $table->string('newsTag');
            $table->string('newsSlug');
            $table->string('newsTime');
            $table->integer('status');
        });
        //tblFeedback bang feedback dung de luu lai cac feedback tu nguoi dung
        Schema::create('tblFeedback', function($table) {
            $table->increments('id');
            $table->string('feedbackUserEmail');
            $table->string('feedbackUserName');
            $table->string('feedbackSubject');
            $table->string('feedbackContent');
            $table->string('feedbackTime');
            $table->integer('status');
        });

        //tbl Admin luu lai cac admin 
        Schema::create('tblAdmin', function($table) {
            $table->increments('id');
            $table->string('adminEmail');
            $table->string('adminName');
            $table->string('adminPassword');
            $table->integer('adminRoles');
            $table->string('adminTime');
            $table->integer('status');
        });
        //tblSupporterGroup luu lai nhom supporter
        Schema::create('tblSupporterGroup', function($table) {
            $table->increments('id');
            $table->string('supporterGroupName');
            $table->string('supporterGroupTime');
            $table->integer('status');
        });
        //tblSupporter danh sach nhung nguoi ho tro ky thuat, tu van ban hang
        Schema::create('tblSupporter', function($table) {
            $table->increments('id');
            $table->integer('supporterGroupID');
            $table->string('supporterNickYH');
            $table->string('supporterNickSkype');
            $table->string('supporterName');
            $table->string('supporterPhone');
            $table->string('supporterTime');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
