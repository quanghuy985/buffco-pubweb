
<?php

function catch_that_image($post) {
    $first_img = '';
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post, $matches);


    if ($matches[1] == NULL || $matches[1] == '') {
        $first_img = Asset('') . "/fontendlib/img/defau.jpg";
    } else {
        $first_img = $matches[1][0];
    }
    if ($first_img == NULL || $first_img == '') {
        $first_img = Asset('') . "/fontendlib/img/defau.jpg";
    }
    return $first_img;
}
?>
@foreach($datanews as $item) 
<article class="post post-medium">
    <div class="row">

        <div class="col-md-5">
            <div class="post-image"> 
                <div>
                    <div class="img-thumbnail">
                        <img title="{{$item->newsName}}" class="img-responsive" src="{{Asset('timthumb.php')}}?src={{catch_that_image($item->newsContent)}}&w=325&h=200&zc=0&q=100" alt="{{$item->newsName}}">
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-md-7">

            <div class="post-content">

                <h2><a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}">{{$item->newsName}}</a></h2>
                <p>{{str_limit($item->newsDescription, 250, ' [...]')}}</p>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="post-meta">
                <span><i class="icon icon-calendar"></i>{{date(' F d , Y ',$item->newsTime)}}</span>
                <span><i class="icon icon-tag"></i>{{$item->newsTag}}</span>                     
                <a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}" class="btn btn-xs btn-primary pull-right">Chi tiết...</a>
            </div>
        </div>
    </div>

</article>
@endforeach
@if($pargion!='')
{{$pargion}}
@endif
