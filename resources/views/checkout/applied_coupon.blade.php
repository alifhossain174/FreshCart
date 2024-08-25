@if(session('coupon') && session('discount') > 0)
    <div class="coupon-code-validate display-flex">
        <div class="coupon-code-validate-data">
            <h6 class="coupon-code-name">
                {{session('coupon')}} <span>({{number_format(session('discount'), 2)}} BDT)</span>
            </h6>
            <p class="coupon-code-applied m-0">
                <i class="fi-br-check"></i>Coupon applied
            </p>
        </div>
        <div class="coupon-code-remove-button">
            <button type="button" onclick="removeAppliedCoupon()" class="theme-btn hover" style="cursor: pointer">
                Remove
            </button>
        </div>
    </div>
@endif
