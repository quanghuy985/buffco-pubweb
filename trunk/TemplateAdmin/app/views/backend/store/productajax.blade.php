  <?php $i = 1; ?>
                @foreach($dataproduct as $item)
                <tr >  
                    <td class="center"><?php echo $i; $i++; ?> </td>
                    <td><a href="{{URL::action('StoreController@getViewStoreProduct')}}?id={{$item->id}}" alt="Thêm hàng vào kho" >{{$item->productName}}</a>  </td>
                    <td><a href="" >{{$item->productCode}}</a></td>                    
                   <td class="center">@if($item->soluong!=null){{$item->soluong}} @else 0 @endif </td>
                    <td class="center">@if($item->daban!=null) {{$item->daban}}  @else 0 @endif </td>
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
                    <td class="center"><a href="{{URL::action('StoreController@getViewStoreProduct')}}?id={{$item->id}}" >Thêm hàng</a> &nbsp;</td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="7">
                        {{$link}}
                    </td>
                </tr>
                @endif
                @if(count($dataproduct)==0)
                <tr>
                    <td colspan="7" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
                </tr>
                @endif