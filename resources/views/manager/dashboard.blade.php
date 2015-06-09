@extends('manager')


@section('content')
@parent

    <div class="row">
        <div class="col-sm-3">
            <div class="xe-widget xe-counter" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-icon">
                    <i class="linecons-cloud"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">0.0%</strong>
                    <span>Server uptime</span>
                </div>
            </div>

            <div class="xe-widget xe-counter xe-counter-purple" data-count=".num" data-from="1" data-to="117" data-suffix="k" data-duration="3" data-easing="false">
                <div class="xe-icon">
                    <i class="linecons-user"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">1k</strong>
                    <span>Users Total</span>
                </div>
            </div>


            <div class="xe-widget xe-counter xe-counter-purple" data-count=".num" data-from="1" data-to="117" data-suffix="k" data-duration="3" data-easing="false">
                <div class="xe-icon">
                    <i class="linecons-user"></i>
                </div>
                <div class="xe-label">
                    <strong class="num">1k</strong>
                    <span>Users Total</span>
                </div>
            </div>
        </div>






    </div>







    @stop