@if(isset($arraySize))
                @foreach($arraySize as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><label value="page">{{str_limit( $item->sizeName, 10, '...')}}</label></td> 
                    <td><label value="page">{{str_limit($item->sizeDescription, 10, '...')}} </label></td> 
                    <td><label value="page">{{str_limit($item->sizeValue, 10, '...')}} </label></td> 
                    
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="page">
                            <?php
                            if ($item->status == 1) {
                                echo "đã kích hoạt";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>
                        <a href="{{URL::action('SizeController@getSizeEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                        @endif
                        @if($item->status=='1')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="7">{{$link}}</td>
                </tr>
                @endif
                
                @endif