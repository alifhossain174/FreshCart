<div class="review-box">
    <div class="row g-4">
        {{-- <div class="col-xl-6">
            <div class="review-title">
                <h4 class="fw-500">Customer reviews</h4>
            </div>

            <div class="d-flex">
                <div class="product-rating">
                    <ul class="rating">
                        <li>
                            <i data-feather="star" class="fill"></i>
                        </li>
                        <li>
                            <i data-feather="star" class="fill"></i>
                        </li>
                        <li>
                            <i data-feather="star" class="fill"></i>
                        </li>
                        <li>
                            <i data-feather="star"></i>
                        </li>
                        <li>
                            <i data-feather="star"></i>
                        </li>
                    </ul>
                </div>
                <h6 class="ms-3">4.2 Out Of 5</h6>
            </div>

            <div class="rating-box">
                <ul>
                    <li>
                        <div class="rating-list">
                            <h5>5 Star</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 68%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100">
                                    68%
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="rating-list">
                            <h5>4 Star</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 67%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100">
                                    67%
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="rating-list">
                            <h5>3 Star</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 42%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100">
                                    42%
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="rating-list">
                            <h5>2 Star</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 30%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100">
                                    30%
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="rating-list">
                            <h5>1 Star</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 24%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100">
                                    24%
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div> --}}

        <div class="col-xl-12">
            <div class="review-title">
                <h4 class="fw-500">Add a review</h4>
            </div>
            <form action="{{url('submit/product/review')}}" method="post" class="review-form">
                @csrf
                <input type="hidden" name="review_product_id" value="{{$product->id}}">
                <div class="row g-4">

                    <div class="col-12">
                        <div class="form-floating theme-form-floating">
                            <textarea name="review" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px"></textarea>
                            <label for="floatingTextarea2">Write Your Comment</label>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-floating theme-form-floating">
                            <select name="rarting" class="form-select" required="">
                                <option value="">Select One</option>
                                <option value="5">Perfect</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Not that bad</option>
                                <option value="1">Very poor</option>
                            </select>
                            <label for="website">Rating</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating theme-form-floating">
                            <button type="submit" class="btn rounded w-100" style="background: var(--theme-color); color: white;">Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-12">
            <div class="review-title">
                <h4 class="fw-500">
                    Customer reviews & reply
                </h4>
            </div>

            <div class="review-people">
                <ul class="review-list">

                    @foreach ($productReviews as $productReview)
                    <li>
                        <div class="people-box">
                            <div>
                                <div class="people-image">
                                    <img src="{{ url('assets') }}/images/user_image.png" class="img-fluid blur-up lazyload" alt="" />
                                </div>
                            </div>

                            <div class="people-comment">
                                <a class="name" href="javascript:void(0)">{{$productReview->username}}</a>
                                <div class="date-time">
                                    <h6 class="text-content">
                                        {{date("F d, Y h:i a", strtotime($productReview->created_at))}}
                                    </h6>
                                    <div class="product-rating">
                                        <ul class="rating">
                                            @for ($i=1;$i<=round($productReview->rating);$i++)
                                                <li><i data-feather="star" class="fill"></i></li>
                                            @endfor
                                            @for ($i=1;$i<=5-round($productReview->rating);$i++)
                                                <li><i data-feather="star"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                                <div class="reply">
                                    <p>
                                        {{$productReview->review}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="review_reply" style="margin-top: 10px; padding: 0px 25px 0px 31px; text-align: justify;">
                            <span style="padding: 4px 10px; background: lightgray; border-radius: 6px; font-weight: 500; margin-bottom: 5px; font-size: 12px;">
                                Replied on {{date("F d, Y h:i a", strtotime($productReview->updated_at))}}
                            </span>
                            <p><strong>{{env('APP_NAME')}} : </strong>{{$productReview->reply}}</p>
                        </div>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</div>
