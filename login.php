<?php

//ABADIES SOLUTIONS

require_once("include/initialize.php");
  if(isset($_SESSION['UID'])){
    redirect("index.php");
    header("Location: index.php");
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>D SOLUTIONS &middot; Sign in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo WEB_ROOT;?>plugins/fontawesome-free/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&family=Playfair+Display:600,700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <style>
    :root{
      --g1:#0b3d24; --g2:#166534; --g3:#15803d;
      --ink:#1f2a37; --muted:#6b7280; --field:#eef1f4; --field-brd:#dfe4ea;
    }
    *{box-sizing:border-box; margin:0; padding:0;}
    html,body{height:100%;}
    body{
      font-family:"Poppins",-apple-system,Segoe UI,Roboto,Arial,sans-serif;
      min-height:100vh; width:100%; overflow:hidden; position:relative;
      display:flex; align-items:center; justify-content:center; padding:20px;
      color:var(--ink);
      background:linear-gradient(-45deg,#e9f5ee,#d7 efe0,#eaf6 f0,#e2f2e9);
      background:linear-gradient(-45deg,#e9f5ee,#d7efe0,#eaf6f0,#e2f2e9);
      background-size:400% 400%; animation:bgShift 18s ease infinite;
    }
    @keyframes bgShift{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}

    /* soft floating shapes behind the card */
    .blob{position:absolute;border-radius:50%;pointer-events:none;filter:blur(1px);}
    .blob.b1{width:300px;height:300px;background:rgba(22,101,52,.10);top:-80px;left:-70px;animation:f1 15s ease-in-out infinite;}
    .blob.b2{width:240px;height:240px;background:rgba(21,128,61,.10);bottom:-70px;right:-60px;animation:f2 13s ease-in-out infinite;}
    .blob.b3{width:150px;height:150px;background:rgba(11,61,36,.08);bottom:60px;left:10%;animation:f3 19s ease-in-out infinite;}
    @keyframes f1{0%,100%{transform:translate(0,0);}50%{transform:translate(28px,36px);}}
    @keyframes f2{0%,100%{transform:translate(0,0);}50%{transform:translate(-34px,-26px);}}
    @keyframes f3{0%,100%{transform:translate(0,0) scale(1);}50%{transform:translate(18px,-22px) scale(1.1);}}

    .card{
      position:relative;z-index:2;width:400px;max-width:94vw;background:#fff;
      border-radius:16px;padding:38px 34px 28px;text-align:center;
      box-shadow:0 22px 55px rgba(11,61,36,.18);
      animation:cardIn .7s cubic-bezier(.2,.8,.2,1) both;
    }
    @keyframes cardIn{0%{opacity:0;transform:translateY(28px) scale(.97);}100%{opacity:1;transform:translateY(0) scale(1);}}

    .logo-wrap{position:relative;width:88px;height:88px;margin:0 auto 12px;}
    .logo-wrap .ring{
      width:88px;height:88px;border-radius:50%;background:#fff;border:2px solid #e6e9ee;
      display:flex;align-items:center;justify-content:center;overflow:hidden;
      box-shadow:0 6px 18px rgba(0,0,0,.10);
      animation:pop .8s .1s cubic-bezier(.2,1.4,.4,1) both;
    }
    .logo-wrap .ring img{width:64px;height:64px;object-fit:contain;}
    .logo-wrap .badge{
      position:absolute;right:-2px;bottom:-2px;width:30px;height:30px;border-radius:50%;
      background:var(--g2);color:#fff;display:flex;align-items:center;justify-content:center;
      font-size:13px;border:3px solid #fff;
    }
    @keyframes pop{0%{transform:scale(0);}100%{transform:scale(1);}}

    .school{font-family:"Playfair Display",Georgia,serif;font-size:19px;font-weight:700;color:var(--ink);line-height:1.25;margin-bottom:14px;}
    .role{color:var(--g2);font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;}
    .title{font-family:"Playfair Display",Georgia,serif;font-size:26px;font-weight:700;margin:2px 0 4px;}
    .subtitle{color:var(--muted);font-size:13px;margin-bottom:24px;}

    .fld{position:relative;text-align:left;margin-bottom:18px;animation:fadeUp .55s both;}
    .fld:nth-of-type(1){animation-delay:.2s;}
    .fld:nth-of-type(2){animation-delay:.3s;}
    @keyframes fadeUp{0%{opacity:0;transform:translateY(12px);}100%{opacity:1;transform:translateY(0);}}
    .fld label{display:block;font-size:11px;font-weight:600;letter-spacing:1px;color:var(--muted);text-transform:uppercase;margin-bottom:6px;}
    .fld .box{position:relative;display:flex;align-items:center;background:var(--field);border:1px solid var(--field-brd);border-radius:10px;transition:.2s;}
    .fld .box:focus-within{border-color:var(--g2);background:#fff;box-shadow:0 0 0 4px rgba(22,101,52,.10);}
    .fld .box .ic{width:44px;text-align:center;color:var(--muted);font-size:15px;}
    .fld input{flex:1;height:48px;border:0;background:transparent;font-family:inherit;font-size:15px;color:var(--ink);padding-right:12px;}
    .fld input:focus{outline:none;}
    .fld .toggle{width:44px;text-align:center;color:var(--muted);cursor:pointer;font-size:15px;}

    .btn-login{
      width:100%;height:50px;border:0;border-radius:10px;cursor:pointer;color:#fff;
      font-family:inherit;font-size:15px;font-weight:600;letter-spacing:.4px;
      background:linear-gradient(90deg,var(--g1),var(--g2));margin-top:4px;position:relative;overflow:hidden;
      transition:transform .12s ease, box-shadow .25s ease;animation:fadeUp .55s .4s both;
    }
    .btn-login:hover{box-shadow:0 12px 26px rgba(11,61,36,.30);}
    .btn-login:active{transform:scale(.98);}
    .btn-login::after{content:"";position:absolute;top:0;left:-120%;width:55%;height:100%;
      background:linear-gradient(120deg,transparent,rgba(255,255,255,.28),transparent);transform:skewX(-20deg);}
    .btn-login:hover::after{animation:shine .9s ease;}
    @keyframes shine{0%{left:-120%;}100%{left:130%;}}

    .foot{margin-top:22px;font-size:11.5px;color:var(--muted);animation:fadeUp .55s .5s both;}
    .foot i{color:var(--g2);}

    @media (max-width:420px){ .card{padding:30px 22px 24px;} .title{font-size:23px;} }
  </style>
</head>
<body>

  <span class="blob b1"></span>
  <span class="blob b2"></span>
  <span class="blob b3"></span>

  <div class="card">
    <div class="logo-wrap">
      <div class="ring"><img src="<?php echo WEB_ROOT;?>csr-scc.png" alt="Logo"></div>
      <div class="badge"><i class="fas fa-user-shield"></i></div>
    </div>

    <div class="school">ABADIES SOLUTIONS</div>
    <div class="role">Administrator</div>
    <div class="title">Sign in to continue</div>
    <div class="subtitle">Enter your credentials to start your session.</div>

    <form action="login.php" method="post" autocomplete="off">
      <div class="fld">
        <label>Username</label>
        <div class="box">
          <span class="ic"><i class="fas fa-user"></i></span>
          <input type="text" name="username" id="username" placeholder="Enter username" autofocus required>
        </div>
      </div>
      <div class="fld">
        <label>Password</label>
        <div class="box">
          <span class="ic"><i class="fas fa-lock"></i></span>
          <input type="password" name="userpass" id="userpass" placeholder="Enter password" required>
          <span class="toggle" id="togglePass" title="Show / hide password"><i class="fas fa-eye"></i></span>
        </div>
      </div>
      <button type="submit" name="btnLogin" class="btn-login">
        <i class="fas fa-sign-in-alt"></i>&nbsp; LOG IN
      </button>
    </form>

    <div class="foot"><i class="fas fa-shield-alt"></i> Restricted area. Unauthorized access is prohibited.</div>
  </div>

<script>
  (function(){
    var t=document.getElementById('togglePass'), p=document.getElementById('userpass');
    if(t){ t.addEventListener('click',function(){
      var i=t.querySelector('i'); var show=p.type==='password';
      p.type=show?'text':'password';
      i.classList.toggle('fa-eye',!show); i.classList.toggle('fa-eye-slash',show);
    });}
  })();
</script>

<?php
if (function_exists('check_message')) { check_message(); }
if (isset($_GET['logout'])) {
  echo '<script>swal({title:"Signed out",text:"You have been logged out successfully.",icon:"success",timer:1800,buttons:false});</script>';
}
?>

<?php
if(isset($_POST['btnLogin'])){

  $email   = trim($_POST['username']);
  $upass   = trim($_POST['userpass']);
  $h_upass = sha1($upass);

  if ($email == '' OR $upass == '') {
    echo '<script>swal("Missing details","Please enter both your username and password.","warning");</script>';
  } else {
    $user = new User();
    $res  = $user::AuthenticateUser($email, $h_upass);
    if ($res==true) {
      ?>
      <script language="javascript">window.location.href = "index.php";</script>
      <?php
    } else {
      echo '<script>swal("Login failed","Invalid username or password. Please try again.","error");</script>';
    }
  }
}
?>

</body>
</html>