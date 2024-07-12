<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4 text-center about-us">
                <h2>About us</h2>
                <p>
                    {{$site_content['footer-about-us'] ?? ''}} 
                </p>
            </div>
            <div class="col-12 col-lg-4 text-center quick-links">
                <h2>Quick links</h2>
                <ul class="m-0 p-0">
                    <li><a href="/">Home</a></li>
                    <li><a href="">About Us</a></li>
                    <li><a href="{{route('home.members')}}">Volunteer</a></li>
                    <li><a href="{{route('home.events')}}">Event</a></li>
                    <li><a href="{{route('home.blogs')}}">Blog</a></li>
                    <li><a href="">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-4 text-center quick-links">
                <h2 class="mb-4">Follow us</h2>
                <div class="d-flex flex-row gap-4 justify-content-center">
                    <a href="{{$site_content['facebook-link'] ?? ''}}" target="_blank"><i class="fs-1 fab fa-facebook"></i></a>
                    <a href="{{$site_content['x-link'] ?? ''}}" target="_blank"><i class="fs-1 fab fa-twitter"></i></a>
                    <a href="{{$site_content['instagram-link'] ?? ''}}" target="_blank"><i class="fs-1 fab fa-instagram"></i></a>
                    <a href="{{$site_content['linkedin-link'] ?? ''}}" target="_blank"><i class="fs-1 fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

</footer>