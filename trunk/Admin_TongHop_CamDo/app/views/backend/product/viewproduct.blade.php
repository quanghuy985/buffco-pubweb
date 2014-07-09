@extends("backend.template")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ SẢN PHẨM</h1>
    <span class="pagedesc">Thêm sửa xóa sản phẩm</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Sản phẩm</h3>
        </div>
        <div class="tableoptions">

            {{Form::open(array('action'=>'\BackEnd\ProductController@postProductFillterView', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            <select class="radius3" name="cat_product_id" id="cat_product_id">
                <option value="">{{Lang::get('general.select-category')}}</option>
                @foreach($allcatelist as $item)
                @if($item->cateParent==0)
                <option value="{{$item->id}}" style="   font-size: 13px;font-weight: bold;text-decoration: inherit;"><strong> {{$item->cateName}}</strong></option>
                @foreach($allcatelist as $item1)
                @if($item->id==$item1->cateParent)
                <option value="{{$item1->id}}">— {{$item1->cateName}}</option>
                @endif
                @endforeach
                @endif
                @endforeach
            </select>
            &nbsp; &nbsp; {{Form::select('status_fillter', Lang::get('general.product_status'),null,array('id'=>'status_fillter','class'=>'radius3'))}}
            &nbsp; <input type="submit" class="radius3" value="{{Lang::get('general.filter')}}">
            {{Form::close()}}
            {{Form::open(array('action'=>'\BackEnd\ProductController@postProductSearchView','id'=>'searchaction'))}}
            <div class="dataTables_filter1" id="searchformfile" style=" margin-top: -32px !important;">
                <label>
                    <input id="searchblur" name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text">
                </label>
                &nbsp; &nbsp;<input type="submit" value="{{Lang::get('general.search')}}" class="radius3"/>
            </div>
            {{Form::close()}}
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 1%">
                <col class="con0" style="width: 1%">
                <col class="con1" style="width: 25%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 5%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 19%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 14%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">{{Lang::get('general.stt')}}</th>
                    <th class="head0">{{Lang::get('general.product.img')}}</th>
                    <th class="head1">{{Lang::get('general.product.name')}}</th>
                    <th class="head0">{{Lang::get('general.product.code')}}</th>                    
                    <th class="head1">{{Lang::get('general.product.quantity')}}</th>
                    <th class="head0">{{Lang::get('general.product.price')}}</th>
                    <th class="head1">{{Lang::get('general.product.price_sales')}}</th>
                    <th class="head0">{{Lang::get('general.time')}}</th>
                    <th class="head1">{{Lang::get('general.product.action')}}</th>
                </tr>
            </thead>
            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.product.productajax')
            </tbody>
        </table>
    </div>
</div>

@endsection