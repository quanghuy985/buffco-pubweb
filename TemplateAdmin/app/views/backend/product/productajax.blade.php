   @foreach($dataproduct as $item)
                <tr >  
                    <td><a href="{{URL::action('ProductController@getEditProduct')}}/{{$item->id}}" >{{$item->productName}}</a>  </td>
                    <td><a href="{{URL::action('ProductController@getEditProduct')}}/{{$item->id}}" >{{$item->productCode}}</a></td>             
                    <td class="center">{{$item->cateName}} </td>
                    <td class="center">{{number_format($item->productPrice,0,'.', ',')}}</td>  
                    <td class="center">@if($item->soluong!=null){{$item->soluong}} @else 0 @endif </td>
                    <td class="center">@if($item->daban!=null) {{$item->daban}}  @else 0 @endif </td>
                    <td class="center">{{number_format($item->salesPrice,0,'.', ',')}}<br/>                    
                        @if($item->startSales!=0 ||$item->endSales!=0)  {{ '(' }}  @endif
                        @if($item->startSales!=0)Từ {{date('d/m/Y',$item->startSales)}} @else  @endif  @if($item->endSales!=0)đến {{date('d/m/Y',$item->endSales)}} @else   @endif
                        @if($item->startSales!=0 ||$item->endSales!=0)  {{ ')' }}  @endif
                    </td> 
                    <td class="center">
                        @if($item->status==0)
                        chờ đăng
                        @endif
                        @if($item->status==1)
                        đã đăng
                        @endif 
                        @if($item->status==2)
                        xóa
                        @endif
                    </td>
                    <td class="center"><a href="{{URL::action('ProductController@getEditProduct')}}/{{$item->id}}" >Sửa</a> &nbsp; || &nbsp; <a href="javascript: void(0)" onclick="xoasanpham('{{$item->id}}')">Xóa</a></td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="9">
                        {{$link}}
                    </td>
                </tr>
                @endif
                @if(count($dataproduct)==0)
                <tr>
                    <td colspan="9" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
                </tr>
                @endif