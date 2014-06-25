<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDb extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('tbl_users', function($table) {
            $table->increments('id');
            $table->string('userEmail');
            $table->string('userPassword');
            $table->string('userFirstName');
            $table->string('userLastName');
            $table->string('userDOB');
            $table->string('userAddress');
            $table->string('userPhone');
            $table->string('verify');
            $table->string('time');
            $table->integer('status');
        });

        //tblFeedback bang feedback dung de luu lai cac feedback tu nguoi dung
        Schema::create('tbl_feed_back', function($table) {
            $table->increments('id');
            $table->string('feedbackUserEmail');
            $table->string('feedbackUserName');
            $table->string('feedbackSubject');
            $table->longtext('feedbackContent');
            $table->string('time');
            $table->integer('status');
        });
        //tblAttachment Dung de attach file luu duong dan vao csdl
        //destinyID la id cua thu muc co file attachment : VD pid neu attachmentURL dc dinh tren Pid day
        Schema::create('tbl_attachment', function($table) {
            $table->increments('id');
            $table->string('destinyID');
            $table->integer('type'); // 0- sản phẩm 1- dự án
            $table->string('attachmentName');
            $table->string('attachmentURL');
            $table->string('time');
            $table->integer('status');
        });


        // tblCategoryProduct luu lai danh muc san pham
        Schema::create('tbl_product_category', function($table) {
            $table->increments('id');
            $table->string('cateName');
            $table->integer('cateParent');
            $table->string('cateSlug');
            $table->longtext('cateDescription');
            $table->string('time');
            $table->integer('status');
        });

        //tblManufacturer luu lai xuat su nguon goc hang hoa
        Schema::create('tbl_product_manufacturer', function($table) {
            $table->increments('id');
            $table->string('manufacturerName');
            $table->string('manufacturerDescription');
            $table->string('manufacturerPlace');
            $table->string('time');
            $table->integer('status');
        });
        //tblProduct
        Schema::create('tbl_product', function($table) {
            $table->increments('id');
            $table->string('productCode');
            $table->integer('cateID');
            $table->string('productName');
            $table->longtext('productDescription');
            $table->longtext('productAttributes');
            $table->decimal('productPrice', 20, 2);
            $table->decimal('salesPrice', 20, 2)->nullable;
            $table->string('startSales')->nullable;
            $table->string('endSales')->nullable;
            $table->integer('total_votes')->nullable;
            $table->integer('total_value')->nullable;
            $table->integer('quantity');
            $table->integer('quantity_sold');
            $table->string('productSlug');
            $table->string('productTag');
            $table->integer('manufactureID');
            $table->string('time');
            $table->integer('status');
        });
        //tblWishlist de luu wishlist cua user
        Schema::create('tbl_product_wishlist', function($table) {
            $table->increments('id');
            $table->string('user_id');
            $table->integer('product_id');
            $table->string('time');
            $table->integer('status');
        });

        // Luu phien lam viec
        Schema::create('tbl_product_order', function($table) {
            $table->increments('id');
            $table->string('orderCode');
            $table->integer('user_id');
            $table->string('receiverName');
            $table->string('receiverPhone');
            $table->string('orderAddress');
            $table->string('time');
            $table->integer('status');
        });
        // Luu chi tiet hoa don
        Schema::create('tbl_product_order_detail', function($table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->decimal('productPrice', 20, 2);
            $table->integer('amount');
            $table->decimal('total', 20, 2);
            $table->string('time');
            $table->integer('status');
        });
        //tblPMeta la bang luu cac thuoc tinh cua san pham VD : LAPTOP1231(pid) - CPU : 400MHZ, RAM :8G
        Schema::create('tbl_product_meta', function($table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('meta_key');
            $table->integer('meta_values');
            $table->string('time');
            $table->integer('status');
        });
        //tblCateNews Bang luu lai category cua Tin Tuc
        Schema::create('tbl_news_category', function($table) {
            $table->increments('id');
            $table->string('catenewsName');
            $table->longtext('catenewsDescription');
            $table->integer('catenewsParent');
            $table->string('catenewsSlug');
            $table->string('time');
            $table->integer('status');
        });
        //tblNews Bang Tin Tuc --- Dung de dua cac tin tuc o ngoai va tin tu admin cho user --- dung de SEO
        Schema::create('tbl_news', function($table) {
            $table->increments('id');
            $table->integer('catenewsID');
            $table->string('newsName'); //name chi co 70 ky tu
            $table->string('newsImg');
            $table->longtext('newsDescription'); //description < 150
            $table->string('newsKeywords');
            $table->longtext('newsContent');
            $table->string('newsTag');
            $table->string('newsSlug'); //check khong trung nhau vi du : tin-tuc , tin-tuc2, count() $slug + 1 -> chuoi tic-tuc+chuoi
            $table->string('adminID');
            $table->string('time');
            $table->integer('status');
        });
        //Luu lai lich su giao dich
        Schema::create('tbl_users_history', function($table) {
            $table->increments('id');
            $table->integer('user_id'); // = 0 neu userid tu bang tblUser, = 1 neu tu bang tblAdmin
            $table->longtext('historyContent');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tbl_admin_history', function($table) {
            $table->increments('id');
            $table->integer('adminID'); //= 0 neu userid tu bang tblUser, = 1 neu tu bang tblAdmin
            $table->longtext('historyContent');
            $table->string('time');
            $table->integer('status');
        });
        //tblStatistic bang thong ke
        Schema::create('tbl_statistic', function($table) {
            $table->increments('id');
            $table->string('from');
            $table->string('to');
            $table->integer('totalProductSold');
            $table->decimal('totalRevenue', 20, 2);
            $table->integer('totalUser');
            $table->integer('totalNews');
            $table->string('time');
            $table->integer('status');
        });

        //tblMenu Bang luu lai menu
        Schema::create('tbl_menus', function($table) {
            $table->increments('id');
            $table->string('menuName');
            $table->string('menuURL');
            $table->integer('menuParent');
            $table->integer('menuPosition');
            $table->string('time');
            $table->integer('status');
        });
        //tblPage bang luu lai cac page
        Schema::create('tbl_pages', function($table) {
            $table->increments('id');
            $table->string('pageName');
            $table->longtext('pageContent');
            $table->string('pageKeywords');
            $table->string('pageTag');
            $table->string('pageSlug');
            $table->string('time');
            $table->integer('status');
        });
        //tblProject bang luu lai cac du an da lam - danh cho web gioi thieu cong ty
        Schema::create('tbl_projects', function($table) {
            $table->increments('id');
            $table->string('projectName');
            $table->string('from');
            $table->string('to');
            $table->longtext('projectDescription');
            $table->longtext('projectContent');
            $table->string('time');
            $table->integer('status');
        });


        //tbl Admin luu lai cac admin 
        Schema::create('tbl_admin', function($table) {
            $table->increments('id');
            $table->string('adminEmail');
            $table->string('adminPassword');
            $table->string('adminName');
            $table->integer('groupadminID');
            $table->string('time');
            $table->integer('status');
        });

        //tblSupporterGroup luu lai nhom supporter
        Schema::create('tbl_supporter_group', function($table) {
            $table->increments('id');
            $table->string('supporterGroupName');
            $table->string('time');
            $table->integer('status');
        });
        //tblSupporter danh sach nhung nguoi ho tro ky thuat, tu van ban hang
        Schema::create('tbl_supporter', function($table) {
            $table->increments('id');
            $table->integer('supporterGroupID');
            $table->string('supporterName');
            $table->string('supporterNickYH');
            $table->string('supporterNickSkype');
            $table->string('supporterPhone');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tbl_admin_group', function($table) {
            $table->increments('id');
            $table->string('groupadminName');
            $table->longtext('groupadminDescription');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tbl_admin_roles', function($table) {
            $table->increments('id');
            $table->string('rolesCode');
            $table->longtext('rolesDescription');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tbl_admin_roles_group', function($table) {
            $table->increments('id');
            $table->integer('groupadminID');
            $table->integer('rolesID');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tbl_setting', function($table) {
            $table->increments('id');
            $table->string('settingKey');
            $table->string('settingValue');
            $table->string('time');
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
