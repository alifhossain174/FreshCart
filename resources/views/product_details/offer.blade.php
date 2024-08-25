@if($product->special_offer && strtotime($product->offer_end_time) > strtotime(date("Y-m-d H:i:s")))
    @php
        $targetDate = $product->offer_end_time;
        $currentDate = new DateTime();
        $endDate = new DateTime($targetDate);
        $interval = $currentDate->diff($endDate);
        $days = $interval->format('%a');
        $hours = $interval->format('%h');
        $minutes = $interval->format('%i');
        $seconds = $interval->format('%s');
    @endphp

    <div class="time deal-timer product-deal-timer mx-md-0 mx-auto" data-hours="{{$hours}}" data-minutes="{{$minutes}}" data-seconds="{{$seconds}}">
        <div class="product-title">
            <h4>Hurry up! Sales Ends In</h4>
        </div>
        <ul>
            <li>
                <div class="counter d-block">
                    <div class="days d-block">
                        <h5 id="days">{{$days}}</h5>
                    </div>
                    <h6>Days</h6>
                </div>
            </li>
            <li>
                <div class="counter d-block">
                    <div class="hours d-block">
                        <h5 id="hours">{{$hours}}</h5>
                    </div>
                    <h6>Hours</h6>
                </div>
            </li>
            <li>
                <div class="counter d-block">
                    <div class="minutes d-block">
                        <h5 id="minutes">{{$minutes}}</h5>
                    </div>
                    <h6>Min</h6>
                </div>
            </li>
            <li>
                <div class="counter d-block">
                    <div class="seconds d-block">
                        <h5 id="seconds">{{$seconds}}</h5>
                    </div>
                    <h6>Sec</h6>
                </div>
            </li>
        </ul>
    </div>

    <script>
        // Set the initial values from Blade variables
        let days = parseInt({{ $days }});
        let hours = parseInt({{ $hours }});
        let minutes = parseInt({{ $minutes }});
        let seconds = parseInt({{ $seconds }});

        // Function to update the countdown
        function updateCountdown() {
            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) {
                        hours--;
                    } else {
                        hours = 23;
                        if (days > 0) {
                            days--;
                        } else {
                            // Countdown finished
                            clearInterval(countdownInterval);
                            alert("Countdown Finished!");
                        }
                    }
                }
            }

            // Update the HTML elements with the new values
            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
        }

        // Start the countdown
        let countdownInterval = setInterval(updateCountdown, 1000);
    </script>

@endif
