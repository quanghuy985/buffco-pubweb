@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">THÀNH VIÊN</h1>
    <span class="pagedesc">Quản lý thành viên</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng tin tức</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
            <div class="tableoptions">
                <button class="deletebutton radius3" title="table1">Delete Selected</button> &nbsp;
                <select class="radius3">
                    <option value="">10</option>
                    <option value="">20</option>
                    <option value="">50</option>
                </select> 
                <select class="radius3">
                    <option value="">Show All</option>
                    <option value="">Delete</option>
                    <option value="">Active</option>
                </select> &nbsp;
                <button class="radius3">Apply Filter</button>
            </div> 
            @if(!isset($Errors))
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con0" style="width: 2%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 5%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 4%">
                    <col class="con0" style="width: 5%">
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 5%">
                    <col class="con1" style="width: 7%">
                    <col class="con0" style="width: 12%">
                    <col class="con1" style="width: 20%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0"><input type="checkbox" class="checkall" name="checkall" ></th>
                        <th class="head1">Email</th>
                        <th class="head0">Tên</th>
                        <th class="head1">Họ và Đệm</th>
                        <th class="head0">Địa chỉ</th>
                        <th class="head1">Điện Thoại</th>
                        <th class="head0">CMND</th>
                        <th class="head1">Điểm</th>
                        <th class="head0">Mã kích hoạt</th>
                        <th class="head1">Ngày khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>
                <tbody>
                    @foreach($arrayUsers as $item)
                    <tr> 
                        <td><input type="checkbox" value="{{$item->id}}"></td> 
                        <td><label value="cateNews">{{$item->userEmail }}</label></td> 
                        <td><label value="cateNews">{{$item->userFirstName }}</label></td> 
                        <td><label value="cateNews">{{str_limit($item->userLastName, 10, '...')}}</label></td> 
                        <td><label value="cateNews">{{str_limit($item->userAddress, 10, '...')}} </label></td> 
                        <td><label value="cateNews">{{str_limit($item->userPhone, 10, '...')}}</label></td> 
                        <td><label value="cateNews">{{str_limit($item->userIdentify, 10, '...')}}</label></td> 
                        <td><label value="cateNews">{{str_limit($item->userPoint, 10, '...')}} </label></td> 
                        <td><label value="cateNews">{{str_limit($item->verify, 10, '...')}}</label></td> 
                        <td><label value="cateNews"><?php echo date('d/m/Y', $item->userTime); ?></label></td> 
                        <td><label value="cateNews"><?php
                                if ($item->status == 0) {
                                    echo "chờ kích hoạt";
                                } else if ($item->status == 1) {
                                    echo "kích hoạt";
                                } else if ($item->status == 2) {
                                    echo "khóa";
                                }
                                ?>
                            </label>
                        </td> 
                        <td>

                            <a href="{{URL::action('UserController@getUserEdit')}}?id={{$item->userEmail}}" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="{{URL::action('UserController@getUserUnlock')}}?id={{$item->userEmail}}" class="btn btn4 btn_flag" title="Mở khóa"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="{{URL::action('UserController@getUserActive')}}?id={{$item->userEmail}}" class="btn btn4 btn_bulb" title="Kích hoạt"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="{{URL::action('UserController@getUserLock')}}?id={{$item->userEmail}}" class="btn btn4 btn_archive" title="Khóa"></a>
                            @endif

                        </td> 
                    </tr> 
                    @endforeach
                    @if($link!='')
                    <tr>
                        <td colspan="12">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>

            </table>

            @else
            <h3>{{$Errors}}</h3>
            @endif
        </div>
    </div>
</div>
@endsection

