<!DOCTYPE html>
<html class="no-overflow">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login - Evidence Telkom Indonesia</title>
   <link rel="stylesheet" href="<?= base_url("assets/bulma/css/") ?>bulma.css">
   <link rel="stylesheet" href="<?= base_url("assets/own/css/") ?>login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
</head>

<body>
   <div class="hero is-fullheight telkom1 no-overflow">
      <div class="columns is-desktop">
         <div class="column is-7">
         </div>
         <div class="column is-5">
            <div class="hero is-fullheight hero-login">
               <div class="dialog-login has-text-white">
                  <div class="pb-2">
                     <h1 class="is-size-3 has-text-weight-bold	has-text-white">Login</h1>
                     <small>Silahkan login untuk melanjutkan</small>
                  </div>
                  <!-- Form Login -->
                  <form action="<?= base_url("home/login") ?>" method="post">

                     <div class="mt-3">
                        <div class="field">
                           <label class="label has-text-white">Username</label>
                           <div class="control has-icons-left">
                              <input class="input form-trans-white" type="text" name="unem">
                              <span class="icon is-small is-left">
                                 <i class="fas fa-user"></i>
                              </span>
                           </div>
                           <div class="field pt-2">
                              <label class="label has-text-white">Password</label>
                              <div class="control has-icons-left">
                                 <input class="input form-trans-white" type="password" name="pass">
                                 <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="btn-container pt-5">
                        <button class="button btn-lgn has-text-white btn-lg" type="submit">Login</button>
                     </div>
                  </form>
                  <!-- End Of Form Login -->

               </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>