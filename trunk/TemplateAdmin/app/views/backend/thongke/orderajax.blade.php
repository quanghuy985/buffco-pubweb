@if(isset($order))
                @foreach($order as $item)
                <tr> 
                     
                    <td><label value="page">{{str_limit( $item->receiverName, 15, '...')}}</label></td> 
                    <td><label value="page">{{str_limit( $item->orderCode, 15, '...')}}</label></td> 
                    <td><label value="page">{{number_format($item->total,0,',', ' ')}} VND </label></td>
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="page">
                            <?php
                            if ($item->status == 0) {
                                echo "chờ kích hoạt";
                            } else if ($item->status == 1) {
                                echo "đã kích hoạt";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="5">{{$link}}</td>
                </tr>
                @endif
                @endif