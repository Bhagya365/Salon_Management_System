@extends('customer_include.main')
@section('pageSpecificStyles')
<!-- internal css codes -->
@endsection

@section('pageSpecificContent')

<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

    <div id="video">
        <div class="preloader">
            <div class="preloader-bounce">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <header>

            <!-- Custom CSS -->
            <link rel="stylesheet" href="{{ asset('user_assets/css/styletheme.css') }}">

            <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> -->
            <!--Background video start-->

            <!--Background video start-->
            <!-- <video autoplay muted loop id="myVideo">
                <source src="{{ URL::asset('assets\images\video-bg.mp4') }}" type="video/mp4">
            </video> -->

            <!--Background video end -->

            <!-- Background image start -->
            <div id="bgImage"></div>
            <!-- Background image end -->



        </header>

        <div id="fullpage" class="fullpage-default">

            <div class="section animated-row" data-section="slide01">
                <div class="section-inner">
                    <div class="welcome-box">
                        <h1 class="welcome-first animate" data-animate="fadeInUp"> <span>Elevate </span> Your Style</h1>
                        <h1 class="welcome-title animate outline" data-animate="fadeInUp">DEFINE YOUR PRESENCE</h1>
                        <p class="animate" data-animate="fadeInUp">Experience Premium Hair, Beauty & Grooming Services For
                            Men & Women</p>
                        <div class="scroll-down next-section animate data-animate=" fadeInUp""><img
                                src="images/mouse-scroll.png" alt=""><span>Scroll Down</span></div>

                    </div>
                </div>
            </div>
            <div class="section animated-row" data-section="slide02">
                <div class="section-inner">
                    <div class="about-section">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 wide-col-laptop">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="about-contentbox">

                                            <div class="animate" data-animate="fadeInUp">
                                                <span class="about-us">About Us</span>
                                                <h2>Who we are?</h2>
                                                <p>Our salon is designed as a modern space where style, comfort, and
                                                    professionalism meet. We focus on delivering high quality hair, beauty,
                                                    and grooming services in a refined and welcoming environment. Every
                                                    detail from consultation to finishing touch is approached with precision
                                                    and care. Through our digital platform, we aim to combine contemporary
                                                    beauty trends with smart salon management, creating a seamless and
                                                    elevated experience.</p>
                                            </div>

                                            <div class="facts-list owl-carousel">

                                                <div class="item animate" data-animate="fadeInUp">
                                                    <div class="counter-box">
                                                        <i class="fa fa-trophy counter-icon" aria-hidden="true"></i><span
                                                            class="count-number">3</span> Awards Won
                                                    </div>
                                                </div>

                                                <div class="item animate" data-animate="fadeInUp">
                                                    <div class="counter-box">
                                                        <i class="fa fa-smile-o counter-icon" aria-hidden="true"></i><span
                                                            class="count-number">1000</span> Happy Clients
                                                    </div>
                                                </div>

                                                <div class="item animate" data-animate="fadeInUp">
                                                    <div class="counter-box">
                                                        <i class="fa fa-desktop counter-icon" aria-hidden="true"></i><span
                                                            class="count-number">6</span> Years Experience
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <figure class="about-img animate" data-animate="fadeInUp"><img
                                                src="assets/images/bg26a.jpg" alt=""></figure>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section animated-row" data-section="slide03">
                <div class="section-inner">
                    <div class="row justify-content-center">
                        <div class="col-md-8 wide-col-laptop">

                            <div class="title-block animate" data-animate="fadeInUp">
                                <span>Services</span>
                                <h2>What We Do?</h2>
                            </div>

                            <div class="services-section">
                                <div class="services-list owl-carousel">
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-scissors"
                                                    aria-hidden="true"></i></span>
                                            <h3>Hair Cutting & Styling</h3>
                                            <p>Elegant haircuts and styling tailored to your unique look. </p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-paint-brush"
                                                    aria-hidden="true"></i></span>
                                            <h3>Hair Coloring</h3>
                                            <p>Rich, vibrant colors and highlights for a stunning transformation.</p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                                            <h3>Hair Treatment</h3>
                                            <p> Deep nourishment to restore strength, shine, and health. </p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-hand-o-up"
                                                    aria-hidden="true"></i></span>
                                            <h3>Manicure & Pedicure</h3>
                                            <p>Luxury nail care for perfectly polished hands and feet. </p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-smile-o"
                                                    aria-hidden="true"></i></span>
                                            <h3>Makeup Services</h3>
                                            <p> Flawless makeup for every special occasion. </p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-heart" aria-hidden="true"></i></span>
                                            <h3>Facial & Skin Care</h3>
                                            <p>Rejuvenating facials for radiant, glowing skin.</p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <h3>Beard Grooming</h3>
                                            <p>Precision grooming for a sharp and confident look.</p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-tint" aria-hidden="true"></i></span>
                                            <h3>Hair Spa</h3>
                                            <p>Relaxing treatments to revive and refresh your hair.</p>
                                        </div>
                                    </div>
                                    <div class="item animate" data-animate="fadeInUp">
                                        <div class="service-box">
                                            <span class="service-icon"><i class="fa fa-gift" aria-hidden="true"></i></span>
                                            <h3>Bridal Packages</h3>
                                            <p>Complete bridal beauty for your perfect day.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section animated-row" data-section="slide04">
                <div class="section-inner">
                    <div class="gallery-section">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 wide-col-laptop">

                                <div class="title-block animate" data-animate="fadeInUp">
                                    <span>Gallery</span>
                                    <h2>Our Creations</h2>
                                </div>

                                <div class="row g-4">

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="portfolio-item">
                                            <img src="assets/images/gallery1.jpg" alt="Project 1" class="img-fluid">
                                            <div class="thumb-inner">
                                                <h4>Appointment Booking</h4>
                                                <p>Clients can easily schedule, reschedule, and cancel appointments online
                                                    with real time availability.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="portfolio-item">
                                            <img src="assets/images/gallery2.jpg" alt="Project 2" class="img-fluid">
                                            <div class="thumb-inner">
                                                <h4>Customer Profiles</h4>
                                                <p>Maintain detailed records of client preferences, visit history, and
                                                    loyalty points for personalized service.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="portfolio-item">
                                            <img src="assets/images/gallery3.jpg" alt="Project 3" class="img-fluid">
                                            <div class="thumb-inner">
                                                <h4>Inventory Control</h4>
                                                <p>Track product usage, stock levels, and supplier orders to keep your salon
                                                    running smoothly.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="section animated-row" data-section="slide05">
                <div class="section-inner">
                    <div class="row justify-content-center">
                        <div class="col-md-7 wide-col-laptop">
                            <div class="title-block title-block-contact animate" data-animate="fadeInUp">
                                <span>Contact</span>
                                <h2>Get In Touch!</h2>
                            </div>

                            <div class="row">

                                <!-- LEFT SIDE: CONTACT INFO -->
                                <div class="col-lg-5 col-md-12 mb-4">
                                    <div class="contact-box">
                                        <div class="contact-row">
                                            <i class="fa fa-map-marker"></i> No. 123, Main Street, Colombo, Sri Lanka
                                        </div>

                                        <div class="contact-row">
                                            <i class="fa fa-phone"></i> +94 77 123 4567
                                        </div>

                                        <div class="contact-row">
                                            <i class="fa fa-envelope"></i> info@example.com
                                        </div>

                                    </div>
                                </div>

                                <!-- RIGHT SIDE: CONTACT FORM -->
                                <div class="col-lg-7 col-md-12">
                                    
                                    @if(session('success'))
                                        <div class="alert custom-success-alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form class="form-horizontal" enctype="multipart/form-data"
                                        action="{{ route('saveContactUs') }}" method="POST" id="saveContact">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-md-6 input-field">
                                                <input type="text" class="form-control custom-input" autocomplete="off"
                                                    id="fName" name="fName" placeholder="Your Name" required>
                                                <small class="text-danger" id="fNameError"></small>
                                            </div>

                                            <div class="col-md-6 input-field">
                                                <input type="email" class="form-control custom-input" autocomplete="off"
                                                    id="email" name="email" placeholder="Your Email" required>
                                                <small class="text-danger" id="emailError"></small>
                                            </div>
                                        </div>

                                        <div class="input-field">
                                            <input type="text" class="form-control custom-input" autocomplete="off"
                                                id="subject" name="subject" placeholder="Subject" required>
                                            <small class="text-danger" id="subjectError"></small>
                                        </div>

                                        <div class="input-field">
                                            <textarea class="form-control custom-input" autocomplete="off" id="message"
                                                name="message" placeholder="Your Message" required></textarea>
                                            <small class="text-danger" id="messageError"></small>
                                        </div>

                                        <button type="submit" class="btn btn-gold-black-contact">Send Message</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
      

    </div>

    <!-- chatbot starts -->
    <div id="chatbot-root">
        <button class="chat-fab" id="chatFab" onclick="toggleChat()">
            <i class="fa fa-comments" id="fabIcon"></i>
        </button>

        <div class="chat-panel" id="chatPanel">
            <div class="chat-top">
                <div class="icon"><i class="fa fa-scissors"></i></div>
                <div>
                    <h5>Glamour Assistant</h5>
                    <small>Online now</small>
                </div>
            </div>
            <div class="chat-scroll" id="chatScroll">
                <div class="bubble bot">Hi! ✨ Welcome to our salon. How can I help you today?</div>
            </div>
            <div class="chips">
                <button onclick="quickChat('Book appointment')">Book</button>
                <button onclick="quickChat('Services')">Services</button>
                <button onclick="quickChat('Working hours')">Hours</button>
                <button onclick="quickChat('Contact info')">Contact</button>
            </div>
            <div class="chat-bar">
                <input type="text" id="chatField" placeholder="Type a message..." onkeypress="if(event.key==='Enter')sendChat()">
                <button onclick="sendChat()"><i class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
        <!-- chatbot ends -->

@endsection

@section('pageSpecificScript')

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
        });

        $("#saveContact").on("submit", function (event) {
   

            // clear old errors
            $("#fNameError").html('');
            $("#emailError").html('');
            $("#subjectError").html('');
            $("#messageError").html('');

            event.preventDefault();

            $.ajax({
                url: '{{route('saveContactUs')}}',
                type: 'POST',
                data: $(this).serialize(),

                success: function (data) {

                    // VALIDATION ERRORS
                    if (data.errors != null) {

                        if (data.errors.fName) {
                            var p = document.getElementById('fNameError');
                            p.innerHTML = data.errors.fName[0];
                        }

                        if (data.errors.email) {
                            var p = document.getElementById('emailError');
                            p.innerHTML = data.errors.email[0];
                        }

                        if (data.errors.subject) {
                            var p = document.getElementById('subjectError');
                            p.innerHTML = data.errors.subject[0];
                        }

                        if (data.errors.message) {
                            var p = document.getElementById('messageError');
                            p.innerHTML = data.errors.message[0];
                        }
                    }

                    // SUCCESS
                    if (data.success != null) {

                        notify({
                            type: "success",
                            title: 'Success',
                            position: { x: "right", y: "top" },
                            autoHide: true,
                            delay: 300
                            position: {
                                x: "right",
                                y: "top"
                            },
                            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                            message: data.success,
                        });

                        // CLEAR FORM
                        $("#saveContact")[0].reset();
                    }
                },

              
            });
        });
    });
</script> -->

<!-- chatbot starts -->

<script>
const chatFab = document.getElementById('chatFab');
const chatPanel = document.getElementById('chatPanel');
const chatScroll = document.getElementById('chatScroll');
const chatField = document.getElementById('chatField');
const fabIcon = document.getElementById('fabIcon');

function toggleChat() {
    const open = chatPanel.classList.toggle('open');
    fabIcon.className = open ? 'fa fa-times' : 'fa fa-comments';
    if (open) setTimeout(() => chatField.focus(), 100);
}

function putMsg(text, who) {
    const d = document.createElement('div');
    d.className = 'bubble ' + who;
    d.textContent = text;
    chatScroll.appendChild(d);
    chatScroll.scrollTop = chatScroll.scrollHeight;
}

function quickChat(text) {
    putMsg(text, 'user');
    setTimeout(() => putMsg(botAnswer(text), 'bot'), 600);
}

function sendChat() {
    const text = chatField.value.trim();
    if (!text) return;
    putMsg(text, 'user');
    chatField.value = '';
    setTimeout(() => putMsg(botAnswer(text), 'bot'), 700);
}

function botAnswer(input) {
    const m = input.toLowerCase();
    if (m.includes('book') || m.includes('appointment')) return "You can book via our Online System or call +94 77 123 4567. Walk-ins welcome too!";
    if (m.includes('service') || m.includes('hair') || m.includes('facial') || m.includes('makeup') || m.includes('bridal')) return "We offer Haircuts, Coloring, Treatments, Manicure, Makeup, Facials, Beard Grooming, Hair Spa & Bridal Packages.";
    if (m.includes('hour') || m.includes('time') || m.includes('open')) return "Mon-Sun: 9AM-8PM";
    if (m.includes('contact') || m.includes('address') || m.includes('phone') || m.includes('location')) return "📍 No.123, Main St, Colombo\n📞 +94 77 123 4567\n✉️ info@example.com";
    if (m.includes('hi') || m.includes('hello')) return "Hello! Ready to elevate your style? 😊";
    if (m.includes('thank')) return "You're welcome! See you at the salon 💛";
    if (m.includes('bye')) return "Goodbye! Stay fabulous ✨";
    return "I'm here to help with bookings & services. Need anything specific?";
}

// Auto-open once per session
if (!sessionStorage.getItem('chatSeen')) {
    setTimeout(() => { if (!chatPanel.classList.contains('open')) toggleChat(); }, 6000);
    sessionStorage.setItem('chatSeen', '1');
}
</script>
<!-- chatbot ends -->

@endsection