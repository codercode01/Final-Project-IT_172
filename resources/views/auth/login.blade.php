<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "icon" href ="/img/Logo.png" type = "image/x-icon">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/Login.css">
</head>
<body>
<header>
    <h1>Admin Page</h1>
  </header>

<div class="wrapper">
  <div class="inner-warpper text-center">
    <div class="logo text-center">
      <img src="/img/Account.png" alt="AC" style="width: 200px;margin-top:10%;margin-bottom: 20px;">
    <h2 class="title">ADMIN</h2>
           <form action="{{ route('auth.check') }}" method="post">
           @if(Session::get('fail'))
               <div class="alert alert-danger"> 
                   {{ Session::get('fail') }}
                </div>
            @endif
            @csrf
                <div class="input-group" >
                   <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                   <span class="text-danger"> @error('email'){{ $message }} @enderror</span>
                </div>
                <div class="input-group">
                   <input type="password" class="form-control" name="password" placeholder="Password">
                   <span class="text-danger"> @error('password'){{ $message }} @enderror</span>
                </div>
                <button type="submit">Login</button>
                <br>
                <br>
                <a href="{{ route('auth.register') }}"> Register Admin Account</a>
                
            </form>
        </div>
    </div>
</div>

</body>
</html>