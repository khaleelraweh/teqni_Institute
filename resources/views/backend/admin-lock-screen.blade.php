
@extends('layouts.admin-auth')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="text-center mt-4">
                <div class="mb-3">
                    <a href="index.html" class="auth-logo">
                        <img src="{{asset('backend/images/logo-dark.png')}}" height="30" class="logo-dark mx-auto" alt="">
                        <img src="{{asset('backend/images/logo-light.png')}}" height="30" class="logo-light mx-auto" alt="">
                    </a>
                </div>
            </div>

            <div class="p-3">
                <form class="form-horizontal mt-3" action="index.html">

                    <div class="text-center mb-4">
                        <img src="{{asset('backend/images/users/avatar-1.jpg')}}" class="rounded-circle avatar-lg img-thumbnail" alt="thumbnail">
                    </div>

                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group text-center row mt-3">
                        <div class="col-12">
                            <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0 row">
                        <div class="col-12 text-center">
                            <a href="pages-login.html" class="text-muted">Not you?</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!-- end cardbody -->
    </div>
@endsection
            
        

     
    

