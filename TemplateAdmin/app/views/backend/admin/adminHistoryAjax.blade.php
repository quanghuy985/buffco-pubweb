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
