<x-main>


    <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
        <!-- Overlay -->
        <div class="overlay"></div>
      
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item slides active">
            <div class="slide-1"></div>
            <div class="hero">
              <hgroup>       
                  <h3>{{__('ui.contact')}}?</h3>
                  <h4>{{__('ui.contact1')}}</h4>
              </hgroup>
            </div>
          </div>


        </div> 
      </div>
    
        <!-- Contact Start -->
        <div class="container-fluid pt-5">
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <div class="row px-xl-5">
                <div class="col-lg-7 mb-5">
                    <div class="contact-form">
                        <div id="success"></div>
                        <form action="{{route('send')}}" method="POST" name="sentMessage" id="contactForm" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="{{__('ui.profile2')}}" required>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" id="email" placeholder="{{__('ui.contact5')}}" required>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control" name="message" rows="5" placeholder="{{__('ui.contact6')}}" required>{{old('message')}}</textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div>
                                <button class="btn buttonAnimation py-2 px-4 mt-3" style="background-color: #65cbad" type="submit" id="sendMessageButton">{{__('ui.contact4')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 mb-5">
                    <h5 class="font-weight-semi-bold mb-3">{{__('ui.footer2')}}</h5>
                    <p>{{__('ui.contact2')}}.</p>

                    <div class="d-flex flex-column">
                        <h5 class="font-weight-semi-bold mb-3">{{__('ui.contact3')}}</h5>
                        <p class="mb-2"><i class="fa fa-envelope text-green mr-3"></i>info@rarityrealm.com</p>
                        <p class="mb-0"><i class="fa fa-phone-alt text-green mr-3"></i>+012 345 67890</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
    
</x-main>