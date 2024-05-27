    @extends('home.components.layout')
    @section('content')
        <div class="page-nav no-margin row">
        </div>
        <div class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <img src="{{ asset('assets/images/istockphoto-1303601244-612x612.jpg') }}" alt="">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h2>Welcome to Spinta Clinic</h2>
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam varius eros consequat auctor
                            gravida. Fusce tristique lacus at urna sollicitudin pulvinar. Suspendisse hendrerit ultrices
                            mauris.Fusce tristique lacus at urna sollicitudin pulvinar. Suspendisse hendrerit ultrices
                            mauris.</p>
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam varius eros consequat auctor
                            gravida. Fusce tristique lacus at urna sollicitudin pulvinar. Suspendisse hendrerit ultrices
                            mauris.Fusce tristique lacus at urna sollicitudin pulvinar. Suspendisse hendrerit ultrices
                            mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam varius eros consequat
                            auctor gravida. Fusce tristique lacus at urna sollicitudin pulvinar. Suspendisse hendrerit
                            ultrices mauris.Fusce tristique lacus at urna sollicitudin pulvinar. Suspendisse hendrerit
                            ultrices mauris.</p>
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam varius eros consequat auctor
                            consectetur adipiscing elit. Nam varius eros consequat auctorconsectetur adipiscing elit. Nam
                            varius eros consequat auctor gravida. Fusce tristique lacus at urna sollicitudin pulvinar.
                            Suspendisse hendrerit ultrices mauris.Fusce tristique lacus at urna adipiscing </p>

                    </div>
                </div>

            </div>
        </div>
        <!-- ######## About US End ####### -->
        <!-- ################# Hospital Detail Starts Here#######################--->
        <div class="top-msg pt-00">
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
    @endsection
