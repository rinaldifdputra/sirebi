    @extends('website.components.layout')
    @section('content')
        <div class="page-nav no-margin row">
        </div>
        <div style="margin-top:0px;" class="row no-margin">
            <div class="col-sm-6">
            </div>
        </div>

        <div class="row contact-rooo no-margin">
            <div class="container">
                <div class="row">
                    <div style="padding:20px" class="col-sm-6">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126892.7831678274!2d106.67304109726561!3d-6.342279700000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ed24dc9519c1%3A0xa5fe54882955795f!2sBIDAN%20MARNI!5e0!3m2!1sid!2sid!4v1720801369763!5m2!1sid!2sid"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="col-sm-6">
                        <div style="margin:50px" class="serv">
                            <h2 style="margin-top:10px;">Hubungi Kami</h2>
                            SIREBI <br>
                            {{ $tentang_kami->alamat }}<br>
                            Phone/WA: {{ $tentang_kami->telp }}<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
