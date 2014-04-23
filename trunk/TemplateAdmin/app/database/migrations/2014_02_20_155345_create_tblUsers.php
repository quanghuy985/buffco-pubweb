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
            $table->string('userDOB');
            $table->string('userAddress');
            $table->string('userPhone');
            $table->string('verify');
            $table->string('time');
            $table->integer('status');
        });
        //tblFeedback bang feedback dung de luu lai cac feedback tu nguoi dung
        Schema::create('tblFeedback', function($table) {
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
        Schema::create('tblAttachment', function($table) {
            $table->increments('id');
            $table->string('destinyID');
            $table->string('attachmentName');
            $table->string('attachmentURL');
            $table->string('time');
            $table->integer('status');
        });
        //Attachment luu anh cua toan bo Project
        Schema::create('tblAttachmentProject', function($table) {
            $table->increments('id');
            $table->string('projectID');
            $table->string('attachmentName');
            $table->string('attachmentURL');
            $table->string('time');
            $table->integer('status');
        });
        // tblCategoryProduct luu lai danh muc san pham
        Schema::create('tblCategoryProduct', function($table) {
            $table->increments('id');
            $table->string('cateName');
            $table->integer('cateParent');
            $table->string('cateSlug');
            $table->longtext('cateDescription');
            $table->string('time');
            $table->integer('status');
        });

        //tblManufacturer luu lai xuat su nguon goc hang hoa
        Schema::create('tblManufacturer', function($table) {
            $table->increments('id');
            $table->string('manufacturerName');
            $table->string('manufacturerDescription');
            $table->string('manufacturerPlace');
            $table->string('time');
            $table->integer('status');
        });
        //tblProduct
        Schema::create('tblProduct', function($table) {
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
            $table->string('productSlug');
            $table->string('productTag');
            $table->integer('manufactureID');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblSize', function($table) {
            $table->increments('id');
            $table->string('sizeName');
            $table->string('sizeDescription');
            $table->string('sizeValue');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblColor', function($table) {
            $table->increments('id');
            $table->string('colorName');
            $table->string('colorCode');
            $table->string('time');
            $table->integer('status');
        });
        // Luu so luong san pham
        Schema::create('tblStore', function($table) {
            $table->increments('id');
            $table->string('productID');
            $table->string('sizeID')->nullable;
            $table->string('colorID')->nullable;
            $table->integer('soluongnhap');
            $table->integer('soluongban');
            $table->string('time');
            $table->integer('status');
        });
        // Luu phien lam viec
        Schema::create('tblOrder', function($table) {
            $table->increments('id');
            $table->string('orderCode');
            $table->integer('userID');
            $table->string('receiverName');
            $table->string('receiverPhone');
            $table->string('orderAddress');
            $table->string('time');
            $table->integer('status');
        });
        // Luu chi tiet hoa don
        Schema::create('tblOrderDetail', function($table) {
            $table->increments('id');
            $table->string('orderCode');
            $table->integer('productID');
            $table->string('sizeID')->nullable;
            $table->string('colorID')->nullable;
            $table->integer('amount');
            $table->decimal('total', 20, 2);
            $table->string('time');
            $table->integer('status');
        });
        //tblCateTag luu danh muc chi tiet cua san pham, cac thuoc tinh
        // VD : Laptop, may tinh de ban
        Schema::create('tblCateTag', function($table) {
            $table->increments('id');
            $table->string('cateTagName');
            $table->string('time');
            $table->integer('status');
        });
        // tblTag dung de luu cac thuoc tinh cua san pham VD : do, xanh, CPU, RAM
        Schema::create('tblTag', function($table) {
            $table->increments('id');
            $table->string('tagKey');
            $table->string('tagValue');
            $table->integer('catetagID');
            $table->string('time');
            $table->integer('status');
        });
        //tblPMeta la bang luu cac thuoc tinh cua san pham VD : LAPTOP1231(pid) - CPU : 400MHZ, RAM :8G
        Schema::create('tblPMeta', function($table) {
            $table->increments('id');
            $table->integer('productID');
            $table->integer('tagID');
            $table->string('time');
            $table->integer('status');
        });
        //tblCateNews Bang luu lai category cua Tin Tuc
        Schema::create('tblCateNews', function($table) {
            $table->increments('id');
            $table->string('catenewsName');
            $table->longtext('catenewsDescription');
            $table->integer('catenewsParent');
            $table->string('catenewsSlug');
            $table->string('time');
            $table->integer('status');
        });
        //tblNews Bang Tin Tuc --- Dung de dua cac tin tuc o ngoai va tin tu admin cho user --- dung de SEO
        Schema::create('tblNews', function($table) {
            $table->increments('id');
            $table->integer('catenewsID');
            $table->string('newsName'); //name chi co 70 ky tu
            $table->string('newsImg');
            $table->string('newsDescription'); //description < 150
            $table->string('newsKeywords');
            $table->longtext('newsContent');
            $table->string('newsTag');
            $table->string('newsSlug'); //check khong trung nhau vi du : tin-tuc , tin-tuc2, count() $slug + 1 -> chuoi tic-tuc+chuoi
            $table->string('adminID');
            $table->string('time');
            $table->integer('status');
        });
        //Luu lai lich su giao dich
        Schema::create('tblHistory', function($table) {
            $table->increments('id');
            $table->integer('userID'); // = 0 neu userid tu bang tblUser, = 1 neu tu bang tblAdmin
            $table->longtext('historyContent');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblAdminHistory', function($table) {
            $table->increments('id');
            $table->integer('adminID'); //= 0 neu userid tu bang tblUser, = 1 neu tu bang tblAdmin
            $table->longtext('historyContent');
            $table->string('time');
            $table->integer('status');
        });
        //tblStatistic bang thong ke
        Schema::create('tblStatistic', function($table) {
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
        Schema::create('tblMenu', function($table) {
            $table->increments('id');
            $table->string('menuName');
            $table->string('menuURL');
            $table->integer('menuParent');
            $table->integer('menuPosition');
            $table->string('time');
            $table->integer('status');
        });
        //tblPage bang luu lai cac page
        Schema::create('tblPage', function($table) {
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
        Schema::create('tblProject', function($table) {
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
        Schema::create('tblAdmin', function($table) {
            $table->increments('id');
            $table->string('adminEmail');
            $table->string('adminPassword');
            $table->string('adminName');
            $table->integer('groupadminID');
            $table->string('time');
            $table->integer('status');
        });

        //tblSupporterGroup luu lai nhom supporter
        Schema::create('tblSupporterGroup', function($table) {
            $table->increments('id');
            $table->string('supporterGroupName');
            $table->string('time');
            $table->integer('status');
        });
        //tblSupporter danh sach nhung nguoi ho tro ky thuat, tu van ban hang
        Schema::create('tblSupporter', function($table) {
            $table->increments('id');
            $table->integer('supporterGroupID');
            $table->string('supporterName');
            $table->string('supporterNickYH');
            $table->string('supporterNickSkype');
            $table->string('supporterPhone');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblGroupAdmin', function($table) {
            $table->increments('id');
            $table->string('groupadminName');
            $table->longtext('groupadminDescription');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblRoles', function($table) {
            $table->increments('id');
            $table->string('rolesCode');
            $table->longtext('rolesDescription');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblGroupAdminRoles', function($table) {
            $table->increments('id');
            $table->integer('groupadminID');
            $table->integer('rolesID');
            $table->string('time');
            $table->integer('status');
        });
        Schema::create('tblSetting', function($table) {
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
