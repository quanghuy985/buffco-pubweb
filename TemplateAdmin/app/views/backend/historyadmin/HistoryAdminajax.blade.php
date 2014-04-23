@if(isset($arrayHistory))
                @foreach($arrayHistory as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>
                    
                    <td><a href="javascript:void(0);" onclick="xxx('{{$item->id}}','{{$item->adminEmail}}','{{$item->adminName}}','{{$item->historyContent}}')">{{str_limit( $item->adminEmail, 15, '...')}}</a></td> 
                    <td><label value="page">{{str_limit($item->adminName, 15, '...')}} </label></td> 
                    <td><label value="page">{{str_limit($item->historyContent, 15, '...')}} </label></td> 
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="page">
                            <?php
                            if ($item->status == 0) {
                                echo "chưa xem";
                            } else if ($item->status == 1) {
                                echo "đã xem";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>
                        
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Chưa xem"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Đã xem"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif
                
                @endif