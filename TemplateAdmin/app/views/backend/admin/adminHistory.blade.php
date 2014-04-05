@extends("templateadmin2.mainfire")
@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý lịch sử</h1>
    <span class="pagedesc">Quản lý lịch sử</span>
</div>

<div class="contentwrapper">
    @if(isset($msg))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$msg}}</p>
            </div>
            @endif
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng quản lý các lịch sử</h3>
        </div>            
        
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                
            </colgroup>
            <thead>
                <tr>
                     
                    <th class="head1">Email</th>
                    <th class="head0">Ten</th>
                    <th class="head1">Nội dung</th>
                    <th class="head0">Khởi tạo</th>
                    
                    
                </tr>  
            </thead>

            <tbody id="tableproduct"> 
                
                
                @if(isset($arrHistory))
                @foreach($arrHistory as $item)
                <tr> 
                    
                    <td><label value="page">{{str_limit( $item->adminEmail, 15, '...')}}</label></td> 
                    <td><label value="page">{{str_limit($item->adminName, 15, '...')}} </label></td> 
                    <td><label value="page">{{str_limit($item->historyContent, 15, '...')}} </label></td> 
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    
                    
                </tr> 
                @endforeach
                @if($link!='')
                    <tr>
                        <td colspan="4">{{$link}}</td>
                    </tr>
                    @endif
                @endif
                
            </tbody>
        </table>
        
        
    </div>
</div>
@endsection

