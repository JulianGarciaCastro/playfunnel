<?php
$isImpersonating = app()->bound('impersonate') && app('impersonate')->isImpersonating();
?>

<?php if ($isImpersonating) { ?>
<div class="impersonation-banner" style="position:fixed;top:0;left:0;right:0;z-index:2000;background:#fbbf24;color:#111827;padding:6px 12px;font-size:13px;display:flex;align-items:center;justify-content:center;gap:12px;">
  <span><?= __('nav_bar.impersonating_as') ?></span>
  <form method="POST" action="<?= route('impersonation.leave') ?>" style="margin:0;">
    <?= csrf_field() ?>
    <button type="submit" style="border:1px solid #111827;background:#111827;color:#ffffff;padding:2px 8px;border-radius:4px;font-size:12px;line-height:1.4;cursor:pointer;">
      <?= __('nav_bar.leave_impersonation') ?>
    </button>
  </form>
</div>
<?php } ?>

<style>
  #guardarHeader {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
  }

  #guardarHeaderMobile {
    display: none !important;
  }

  @media only screen and (max-width: 991px) {
    #guardarHeader {
      display: none !important;
    }

    #guardarHeaderMobile {
      display: flex !important;
      align-items: center;
      justify-content: center;
    }
  }
</style>

<div class="NavUp fixed-top m-0 p-0 d-flex px-2 align-items-center" style="<?= $isImpersonating ? 'top:32px;' : '' ?>">
    <nav class="navbar navbar-expand-lg  navbar-dark p-0 d-flex justify-content-between w-100">

        <button class="navbar-toggler d-md-none d-inline mr-2" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-home" onclick="window.location='/projects'"></i>
          <!--<a class="home" href="/dashboard"><i class="d-lg-none fas fa-home c03"></i></a>-->
        </button>

        <a href="/projects"><img src="<?= asset('images/SVG/Logo-Horizontal-BgDark.svg') ?>" class="logoImg col-6 col-md-2" alt="playFunnel"></a>

        <div class="dropdown d-flex align-items-center">
          <button id="guardarHeader"   type="submit" class="btn-WhiteBorder mr-4 d-lg-inline d-none" ><?= __('nav_bar.save') ?></button>
           <div class="ml-4">
              <div id="langs-2" class="d-flex justify-content-center flex-column">
                  <a href="/locale/es" class="<?= (app()->getLocale()=='es')?'active':'d-none' ?>"><img src="https://flagicons.lipis.dev/flags/4x3/es.svg" class="  " alt="Descripción de la imagen" style="width:20px"></a>
                  <a href="/locale/en" class="<?= (app()->getLocale()=='en')?'active':'d-none' ?>"><img src="https://flagicons.lipis.dev/flags/4x3/gb.svg" class="  " alt="Descripción de la imagen" style="width:20px"></a>
              </div>
              <i id="langs-down" class="ml-2 mr-4 fa fa-caret-down cWhite" aria-hidden="true"></i>



           </div>
          <a class="navbar-brand d-flex align-items-center" href="#" data-toggle="dropdown"><i class="far fa-user-circle"></i></a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?= route('profile') ?>"><i class="fas fa-address-card"></i><span ><?= __('nav_bar.profile') ?></span></a>
            <?php if (false)  {?>
            	<a class="dropdown-item" href="/billing"><i class="fas fa-credit-card"></i><span ><?= __('nav_bar.billing') ?></span></a>
            <?php } ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= route('logout') ?>"><i class="fas fa-sign-out-alt"></i><span ><?= __('nav_bar.logout') ?></span></a>
            </div>
        </div>

        <!--
        <div class="collapse navbar-collapse" id="navbarNav">
        </div>-->
    </nav>
</div>
<div class="btn-float  d-flex" aria-labelledby="navbarDropdown">
    <button type="submit" class="d-lg-none d-flex align-items-center justify-content-center mr-2">
        <span class="material-icons d-flex justify-content-center">clear</span>
    </button>
    <button id="guardarHeaderMobile" type="submit" class="d-lg-none d-flex align-items-center justify-content-center btn-save"><?= __('nav_bar.save') ?></button>
</div>

<script>
function goBack() {
  //window.history.back();
  window.location = document.referrer;
}


document.addEventListener('DOMContentLoaded', function() {
    var langsDown = document.getElementById('langs-down');
    var langs = document.getElementById('langs-2') || document.getElementById('langs');

    if (!langsDown || !langs) {
      return;
    }

    langsDown.addEventListener('click', function() {
      Array.prototype.forEach.call(langs.querySelectorAll('a'), function(langLink) {
        if (!langLink.classList.contains('active')) {
          langLink.classList.toggle('d-none');
        } else {
          langs.insertBefore(langLink, langs.firstChild);
        }
      });
      langsDown.classList.toggle('rotate');
    });
});


</script>



