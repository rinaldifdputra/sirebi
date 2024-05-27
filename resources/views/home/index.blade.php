@extends('home.components.layout')
@section('content')
    <!-- ################# Slider Starts Here#######################--->
    <div class="slider-detail">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>

            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('assets/images/slider/slide-02.jpg') }}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class=" bounceInDown">Best Free Hospital Template</h5>
                        <p class=" bounceInLeft">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam justo
                            neque, <br>
                            aliquet sit amet elementum vel, vehicula eget eros. Vivamus arcu metus, mattis <br>
                            sed sagittis at, sagittis quis neque. Praesent.</p>

                        <div class="row vbh">

                            <div class="btn btn-success  bounceInUp"> Book an Appointment </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('assets/images/slider/slide-03.jpg') }}" alt="Third slide">
                    <div class="carousel-caption vdg-cur d-none d-md-block">
                        <h5 class=" bounceInDown">Best Free Hospital Template</h5>
                        <p class=" bounceInLeft">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam justo
                            neque, <br>
                            aliquet sit amet elementum vel, vehicula eget eros. Vivamus arcu metus, mattis <br>
                            sed sagittis at, sagittis quis neque. Praesent.</p>

                        <div class="row vbh">

                            <div class="btn btn-success  bounceInUp"> Book an Appointment </div>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


    </div>

    <!-- ################# Hospital Detail Starts Here#######################--->
    <div class="top-msg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 vkjd ohs">
                    <h2><i class="far fa-clock"></i> Opening Hours</h2>
                    <ul>
                        <li>Mon - Fri <span>8.30AM - 7.30PM</span></li>
                        <li>Saturday - Fri <span>6.30AM - 9.30PM</span></li>
                        <li>Sunday - Fri <span>11.30AM - 3.30PM</span></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 vkjd">
                    <h2><i class="fas fa-calendar-alt"></i> Doctors Timetable</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent interdum posuere eleifend.
                        Aenean quis ultricies orci. Duis ullamcorper eros id urna viverra</p>
                </div>
                <div class="col-lg-3 col-md-6 vkjd">
                    <h2><i class="far fa-envelope"></i> Appointments</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent interdum posuere eleifend.
                        Aenean quis ultricies orci. Duis ullamcorper eros id urna viverra</p>
                </div>
                <div class="col-lg-3 col-md-6 vkjd">
                    <h2><i class="fas fa-phone"></i> Emergency Cases</h2>
                    <h4>1-898-8767-568</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ################# AppointmentStarts Here#######################--->
    <div class="professional-details">
        <div class="layy">
            <div class="container">
                <div class="title-another row">
                    <h4>We Are Professionals</h4>
                    <h2>Professional Approach</h2>
                    <h3>and Quality Services</h3>
                    <div class="btn-ro">
                        <button class="btn btn-default">Book an Appointment</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- ################# Our Team Starts Here#######################--->
    <section class="our-team">
        <div class="container">
            <div class="inner-title row">
                <h2>Our Team</h2>
                <p>Take a look at our Team</p>
            </div>
            <div class="row team-row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-usr">
                        <img src="assets/images/team/team-memb1.jpg" alt="">
                        <div class="det-o">
                            <h4>David Kanuel</h4>
                            <i>Facial Surgan</i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-usr">
                        <img src="assets/images/team/team-memb2.jpg" alt="">
                        <div class="det-o">
                            <h4>David Kanuel</h4>
                            <i>Facial Surgan</i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-usr">
                        <img src="assets/images/team/team-memb3.jpg" alt="">
                        <div class="det-o">
                            <h4>David Kanuel</h4>
                            <i>Facial Surgan</i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-usr">
                        <img src="assets/images/team/team-memb4.jpg" alt="">
                        <div class="det-o">
                            <h4>David Kanuel</h4>
                            <i>Facial Surgan</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- ################# Testimonial Starts Here#######################--->
    <section class="testimonial-container">
        <div class="container">
            <div class="inner-title row">
                <h2>Testimonial</h2>
                <p>Take a look at what people say about us</p>
            </div>
            <div class="row">
                <div class="col-md-offset-2 float-auto col-md-10">
                    <div id="testimonial-slider" class="owl-carousel">
                        <div class="testimonial">
                            <div class="pic">
                                <img src="assets/images/testimonial/member-01.jpg" alt="">
                            </div>
                            <p class="description">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda deleniti dolor ipsum
                                molestias mollitia ut. Aliquam aperiam corporis cumque debitis delectus dignissimos.
                                Lorem ipsum dolor sit amet, consectetur.
                            </p>
                            <h3 class="title">williamson
                                <span class="post"> - Developer</span>
                            </h3>
                        </div>

                        <div class="testimonial">
                            <div class="pic">
                                <img src="assets/images/testimonial/member-02.jpg" alt="">
                            </div>
                            <p class="description">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda deleniti dolor ipsum
                                molestias mollitia ut. Aliquam aperiam corporis cumque debitis delectus dignissimos.
                                Lorem ipsum dolor sit amet, consectetur.
                            </p>
                            <h3 class="title">Kristina
                                <span class="post"> - Teacher</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
