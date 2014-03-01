@extends("templateadmin2.mainfire")
@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">TIN TỨC</h1>
    <span class="pagedesc">Quản lý tin tức</span>
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
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con0" style="width: 3%">
                    <col class="con1" style="width: 3%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 14%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0"><input type="checkbox" class="checkall" name="checkall" ></th>
                        <th class="head1">ID</th>
                        <th class="head0">Tiêu đề</th>
                        <th class="head1">Nhóm tin tức</th>
                        <th class="head0">Miêu tả</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody>
                    @foreach($arrayNews as $item)
                    <tr> 
                        <td><input type="checkbox" value="{{$item->id}}"></td> 
                        <td><label value="cateNews">{{$item->id }}</label></td> 
                        <td><label value="cateNews">{{str_limit( $item->newsName, 30, '...')}}</label></td> 
                        <td><label value="cateNews">{{$item->cateNewsName }}</label></td> 
                        <td><label value="cateNews">{{str_limit($item->newsDescription, 30, '...')}} </label></td> 
                        <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->newsTime); ?></label></td> 
                        <td><label value="cateNews"><?php
                                if ($item->status == 0) {
                                    echo "chờ đăng";
                                } else if ($item->status == 1) {
                                    echo "đã đăng";
                                } else if ($item->status == 2) {
                                    echo "đã xóa";
                                }
                                ?>
                            </label>
                        </td> 
                        <td>

                            <a href="{{URL::action('NewsController@getNewsEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="{{URL::action('NewsController@getNewsActive')}}?id={{$item->id}}" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="{{URL::action('NewsController@getNewsPost')}}?id={{$item->id}}" class="btn btn4 btn_world" title="Đăng bài"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="{{URL::action('NewsController@getNewsDelete')}}?id={{$item->id}}" class="btn btn4 btn_trash" title="Xóa"></a>
                            @endif

                        </td> 
                    </tr> 
                    @endforeach
                    @if($link!='')
                    <tr>
                        <td colspan="9">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    @endsection
