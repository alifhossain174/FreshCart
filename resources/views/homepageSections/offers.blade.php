<!-- Offer Section Start -->
<section class="bank-section overflow-hidden">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Promotional Offers</h2>
        </div>
        <div class="slider-bank-3 arrow-slider slick-height">

            @forEach($promoOffers as $offer)
            <div>
                <div class="bank-offer">
                    <div class="bank-header">
                        <div class="bank-left w-100">
                            {{-- <div class="bank-image">
                                <img src="{{url('assets')}}/images/product-load.gif" data-src="{{url(env('ADMIN_URL')."/".$offer->icon)}}" class="lazy img-fluid" alt="" />
                            </div> --}}
                            <div class="bank-name">
                                <h2>{{$offer->title}}</h2>
                                <h5 class="discount text-content">{{$offer->description}}</h5>
                                @php
                                    $currentDate = date("Y-m-d");
                                    $expireDate = $offer->expire_date;
                                    $currentDateTime = new DateTime($currentDate);
                                    $expireDateTime = new DateTime($expireDate);
                                    $interval = $currentDateTime->diff($expireDateTime);
                                    $daysDifference = $interval->days;
                                @endphp
                                <h5 class="valid text-content">Valid for {{$daysDifference}} days</h5>
                            </div>
                        </div>

                        <div class="bank-right w-100">
                            <img src="{{url('assets')}}/images/product-load.gif" data-src="{{url(env('ADMIN_URL')."/".$offer->icon)}}" class="lazy img-fluid" alt="" />
                        </div>
                    </div>

                    @php
                        $randomColor = App\Http\Controllers\FrontendController::generateRandomHexColor();
                        $randomColorLight = App\Http\Controllers\FrontendController::lightenHexColor($randomColor, 75);
                    @endphp

                    <div class="bank-footer bank-footer-1" style="background: linear-gradient(to right, {{$randomColor}}, {{$randomColorLight}}); ">
                        <h4>
                            Code :
                            <input id="clipboardexample" value="{{$offer->code}}" />
                        </h4>
                        <button style="background: {{$randomColor}}" type="button" class="bank-coupon btn" id="copyText" data-clipboard-action="copy" data-clipboard-target="#clipboardexample">
                            Copy Code
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Offer Section End -->
