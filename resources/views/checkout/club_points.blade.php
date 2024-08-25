{{-- <div class="accordion accordion-gutter-md accordion-border mt-3"
    style="background: var(--white-color); border-radius: 4px;">
    <div class="card">
        <div class="card-header" style="background-color: var(--grey-color-light);">
            <a href="#collapseCoupon" class="expand">Use Club Points</a>
        </div>
        <div id="collapseCoupon" class="card-body collapsed" style="padding: 10px;">
            <div class="club-points-form">
                <div class="form-group">
                    <label>You have<b>{{ Auth::user()->balance }} Club Points</b>available</label>
                    <input type="number" id="reward_points_used"
                        @if (session('reward_points')) value="{{ session('reward_points') }}" @endif
                        name="reward_points_used" placeholder="Enter amount of points to spend"
                        max="{{ Auth::user()->balance }}" />
                </div>
                <div class="checkout-checkbox-details">
                    <input class="form-check-input" type="checkbox" id="use_maximum"
                        onclick="userMaximumPoints({{ Auth::user()->balance }})" />
                    <label class="form-check-label" for="use_maximum">Use maximum<b>{{ Auth::user()->balance }} Club
                            Points</b></label>
                </div>
                <div class="club-points-form-btn">
                    <button type="button" onclick="useRewardPoints()" class="theme-btn">
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Use Club Points
        </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="club-points-form">
                <div class="form-group">
                    <label>You have<b>{{ Auth::user()->balance }} Club Points</b>available</label>
                    <input type="number" id="reward_points_used" @if (session('reward_points')) value="{{ session('reward_points') }}" @endif name="reward_points_used" placeholder="Enter amount of points to spend" max="{{ Auth::user()->balance }}" />
                </div>
                <div class="checkout-checkbox-details">
                    <input class="form-check-input" type="checkbox" id="use_maximum"
                        onclick="userMaximumPoints({{ Auth::user()->balance }})" />
                    <label class="form-check-label" for="use_maximum">Use maximum<b>{{ Auth::user()->balance }} Club
                            Points</b></label>
                </div>
                <div class="club-points-form-btn">
                    <button type="button" onclick="useRewardPoints()" class="theme-btn">
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
