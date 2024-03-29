@extends("fontend.hometemplate")

@section("contenthomepage")
<div class="slider-container">
    <div class="slider" id="revolutionSlider">
        <ul>
            <li data-transition="fade" data-slotamount="13" data-masterspeed="300" >

                <img src="{{Asset('fontendlib/img/slides/slide-bg.jpg')}}" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                <div class="tp-caption sft stb visible-lg"
                     data-x="72"
                     data-y="180"
                     data-speed="300"
                     data-start="1000"
                     data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-title-border.png')}}" alt=""></div>

                <div class="tp-caption top-label lfl stl"
                     data-x="122"
                     data-y="180"
                     data-speed="300"
                     data-start="500"
                     data-easing="easeOutExpo">DO YOU NEED A NEW</div>

                <div class="tp-caption sft stb visible-lg"
                     data-x="372"
                     data-y="180"
                     data-speed="300"
                     data-start="1000"
                     data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-title-border.png')}}" alt=""></div>

                <div class="tp-caption main-label sft stb"
                     data-x="30"
                     data-y="210"
                     data-speed="300"
                     data-start="1500"
                     data-easing="easeOutExpo">WEB DESIGN?</div>

                <div class="tp-caption bottom-label sft stb"
                     data-x="80"
                     data-y="280"
                     data-speed="500"
                     data-start="2000"
                     data-easing="easeOutExpo">Check out our options and features.</div>

                <div class="tp-caption randomrotate"
                     data-x="800"
                     data-y="248"
                     data-speed="500"
                     data-start="2500"
                     data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-1.png')}}" alt=""></div>

                <div class="tp-caption sfb"
                     data-x="850"
                     data-y="200"
                     data-speed="400"
                     data-start="3000"
                     data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-2.png')}}" alt=""></div>

                <div class="tp-caption sfb"
                     data-x="820"
                     data-y="170"
                     data-speed="700"
                     data-start="3150"
                     data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-3.png')}}" alt=""></div>

                <div class="tp-caption sfb"
                     data-x="770"
                     data-y="130"
                     data-speed="1000"
                     data-start="3250"
                     data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-4.png')}}" alt=""></div>

                <div class="tp-caption sfb"
                     data-x="500"
                     data-y="80"
                     data-speed="600"
                     data-start="3450"
                     data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-5.png')}}" alt=""></div>

                <div class="tp-caption blackboard-text lfb "
                     data-x="530"
                     data-y="300"
                     data-speed="500"
                     data-start="3450"
                     data-easing="easeOutExpo" style="font-size: 37px;">Think</div>

                <div class="tp-caption blackboard-text lfb "
                     data-x="555"
                     data-y="350"
                     data-speed="500"
                     data-start="3650"
                     data-easing="easeOutExpo" style="font-size: 47px;">Outside</div>

                <div class="tp-caption blackboard-text lfb "
                     data-x="580"
                     data-y="400"
                     data-speed="500"
                     data-start="3850"
                     data-easing="easeOutExpo" style="font-size: 32px;">The box :)</div>
            </li>
            <li data-transition="fade" data-slotamount="5" data-masterspeed="1000" >

                <img src="{{Asset('fontendlib/img/slides/slide-bg.jpg')}}" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                <div class="tp-caption fade"
                     data-x="50"
                     data-y="100"
                     data-speed="1500"
                     data-start="500"
                     data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-concept.png')}}" alt=""></div>

                <div class="tp-caption blackboard-text fade "
                     data-x="180"
                     data-y="180"
                     data-speed="1500"
                     data-start="1000"
                     data-easing="easeOutExpo" style="font-size: 30px;">easy to</div>

                <div class="tp-caption blackboard-text fade "
                     data-x="180"
                     data-y="220"
                     data-speed="1500"
                     data-start="1200"
                     data-easing="easeOutExpo" style="font-size: 40px;">customize!</div>

                <div class="tp-caption main-label sft stb"
                     data-x="580"
                     data-y="190"
                     data-speed="300"
                     data-start="1500"
                     data-easing="easeOutExpo">DESIGN IT!</div>

                <div class="tp-caption bottom-label sft stb"
                     data-x="580"
                     data-y="250"
                     data-speed="500"
                     data-start="2000"
                     data-easing="easeOutExpo">Create slides with brushes and fonts.</div>



            </li>
        </ul>
    </div>
</div>
@endsection