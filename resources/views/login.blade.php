<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Landing Page - Start Bootstrap Theme</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"
        type="text/css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .error{
            color:red;
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#!">Start Bootstrap</a>

            <div class="nav-link">
                <!-- Button trigger modal -->
                @if(empty(auth()->guard('user')->id()))
                <a href="#signup" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Login">Login</a>

                <a class="btn btn-primary" href="#signup" data-bs-toggle="modal" data-bs-target="#Signup">Sign Up</a>
                @else
                  
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hi, {{Session::get('UserData')->name}}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('frontend.logout')}}">Logout</a></li>
                        </ul>
                    </div>
                @endif

            </div>

        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">

                        @if(!empty(auth()->guard('user')->id()))
                        <h1 class="mb-5">Update Your profile here</h1>
                        <form action="{{route('frontend.profile')}}" class="text-start" method="post" name="editPro" id="editPro">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-control">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control required" required maxlength="50" value="{{$userData->name??old('name')??''}}" placeholder="Name" readonly>
                            </div>
                            <div class="form-control">
                                <input type="hidden" name="checkemail" id="checkemail" value="{{$userData->email??old('email')??''}}">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control required" required maxlength="50" value="{{$userData->email??old('email')??''}}" placeholder="Email">
                            </div>
                            <div class="form-control change-email-div" style="display:none">
                                    <label for="password_gchng">Password</label>
                                    <input type="password" name="password_gchng" id="password_gchng" class="form-control required" required maxlength="50" value="" placeholder="Password">
                                </div>
                            <div class="form-control">
                                <label for="name">Phone Number</label>
                                <input type="text" name="phonenumber" id="phonenumber" class="form-control required" required maxlength="50" value="{{$userData->phonenumber??old('phonenumber')??''}}" placeholder="Phone Number">
                            </div>
                            <div class="form-control">
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" value="" name="chngPass" id="chngPass" >
                                    <label class="form-check-label" for="chngPass">
                                        Change Password
                                    </label>
                                </div>
                            </div>
                            <div class="Password-Section" style="display:none;">
                                
                                <div class="form-control">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" name="old_password" id="old_password" class="form-control required" required maxlength="50" value="" placeholder="Old Password">
                                </div>
                                <div class="form-control">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control required" required maxlength="50" value="" placeholder="New Password">
                                </div>
                                <div class="form-control">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control required" required maxlength="50" value="" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="form-control text-center">
                                <input class="btn btn-primary" type="submit" value="Submit">
                            </div>
                        </form>
                        @else
                        <h1 class="mb-5">Generate more leads with a professional landing page!</h1>
                        <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <div class="row">
                                <div class="col">
                                    <input class="form-control form-control-lg" id="emailAddress" type="email"
                                        placeholder="Email Address" data-sb-validations="required,email" />
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:required">
                                        Email Address is required.</div>
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:email">Email
                                        Address Email is not valid.</div>
                                </div>
                                <div class="col-auto"><button class="btn btn-primary btn-lg disabled" id="submitButton"
                                        type="submit">Submit</button></div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- popup section -->
    <section class="modal-wrap">
        <!-- Modal  login -->
        <div class="modal fade" id="Login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
                       


                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-wrap">
                            <form class="row g-3 needs-validation" name="loginForm" id="loginForm" method="post" action="{{route('frontend.login')}}" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="col-md-12">
                                    <label for="email_username" class="form-label">Username or Email Address</label>
                                    <input type="text" name="email_username" id="email_username" class="form-control required" value=""
                                        required maxlength="50">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                               
                                
                                <div class="col-md-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                      
                                      <input type="password" class="form-control required" name="password" id="password" aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                    <div class="link-wrap d-flex justify-content-between ">
                                        
                                       
                                        <a href="#">Lost Password</a> <a href="#">Register</a>
                                    </div>
                                  </div>
                                
                                  <div class="col-12">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                      <label class="form-check-label" for="invalidCheck">
                                        Remember me
                                      </label>
                                      <div class="invalid-feedback">
                                        You must agree before submitting.
                                      </div>
                                    </div>
                                  </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="button" id="submitLogin">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Modal  Signup -->
        <div class="modal fade" id="Signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Sign UP</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-wrap">
                            <form class="row g-3 needs-validation" name="signup" id="signup" method="post" action="{{route('frontend.register')}}" novalidate>
                                
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control required" value="{{old('name')??''}}" name="name" id="name" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="phonenumber" class="form-label">Phone No.</label>
                                    <input type="number" name="phonenumber" id="phonenumber" class="form-control required" value="{{old('phonenumber')??''}}"
                                    required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control required" value="{{old('email')??''}}" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                               
                                
                                <div class="col-md-12">
                                    <label for="password" class="form-label">Choose a Password </label>
                                    <div class="input-group">
                                      
                                      <input type="password" name="password" id="password" class="form-control required" aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                  </div>
                              
                                
                                <div class="col-md-12">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                      
                                      <input type="password" name="confirm_password" id="confirm_password" class="form-control required" aria-describedby="inputGroupPrepend2" required>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-check">
                                      <input class="form-check-input required" type="checkbox" value="" name="isvalid" id="invalidCheck" required>
                                      <label class="form-check-label" for="invalidCheck">
                                        Agree to terms and conditions
                                      </label>
                                      <div class="invalid-feedback">
                                        You must agree before submitting.
                                      </div>
                                    </div>
                                  </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="button" id="signupbtn">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>

    </section>


    <!-- Footer-->
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="#!">About</a></li>
                        <li class="list-inline-item">⋅</li>
                        <li class="list-inline-item"><a href="#!">Contact</a></li>
                        <li class="list-inline-item">⋅</li>
                        <li class="list-inline-item"><a href="#!">Terms of Use</a></li>
                        <li class="list-inline-item">⋅</li>
                        <li class="list-inline-item"><a href="#!">Privacy Policy</a></li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2023. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-4">
                            <a href="#!"><i class="bi-facebook fs-3"></i></a>
                        </li>
                        <li class="list-inline-item me-4">
                            <a href="#!"><i class="bi-twitter fs-3"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><i class="bi-instagram fs-3"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="jquery/jquery.min.js"></script>
    <script src="alertifyjs/build/alertify.min.js"></script>
    <script src="jquery-validation/dist/jquery.validate.js"></script>
    <script src="jquery-validation/dist/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/form-validattion.js"></script>
    <script src="js/scripts.js"></script>
  
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script>
        
        $('#signupbtn').click(function(){
            if($('#signup').valid()){
                $('#signup').submit();
            }
        })

        $('#submitLogin').click(function(){
            var obj = $(this).parents('form');
            // if($(obj).valid()){
                $(obj).submit();
            // }
        })

        $('#chngPass').change(function(){
            if($(this).is(':checked')){
                $('.Password-Section').show();
            }else{
                // alert('not checked');
                $('.Password-Section').hide();

            }
        })
        $('#email').on('change keyup',function(){
            var old_mail = $('#checkemail').val();
            var new_mail = $(this).val();
            if(old_mail == new_mail){
                $('.change-email-div').hide()
                
            }else{
                $('.change-email-div').show()
            }
        })
        @if(Session::has('success'))
            showNotify('success', `{{ Session::get("success") }}`);
            @php Session::forget('success'); @endphp
        @endif

        @if(Session::has('warning'))
            showNotify('warning', `{!! Session::get("warning") !!}`);
            @php Session::forget('warning'); @endphp
        @endif

        @if(Session::has('error'))
            showNotify('error', `{!! Session::get("error") !!}`);
            //@php Session::forget('error'); @endphp
        @endif

        @if(Session::has('info'))
            showNotify('info', `{{ Session::get("info") }}`);
            @php Session::forget('info'); @endphp
        @endif

        @foreach ($errors->all() as $error)
            showNotify('error', `{{ $error }}`);
        @endforeach
    </script>
</body>

</html>