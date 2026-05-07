<div class="sideNav col d-flex align-items-center justify-content-center" id="navbarNav">
    <ul class="navbar-nav p-0 ">
      <li class="nav-item">
        <?php if(Route::currentRouteName() == 'dashboard'): ?>
          <i class="c01 fa fa-line-chart""></i>
          <span  class="c01" style="cursor: default">{{__('dashboard.dashboard')}}</span>
        <?php else: ?>
          <a class="nav-link cMain text-md-left"     href="{{ route('dashboard') }}"><i class="fa fa-line-chart"></i>
              <span  class="cMain">{{__('dashboard.dashboard')}}</span>
          </a>
        <?php endif; ?>
      </li>

      <li class="nav-item">
        <?php if(Route::currentRouteName() == 'projects'): ?>
          <i class="c01 fas fa-th-large "></i>
          <span  class="c01" style="cursor: default">{{__('dashboard.projects')}}</span>
        <?php else: ?>
          <a class="nav-link cMain text-md-left"     href="{{ route('projects') }}"><i class="fas fa-th-large "></i>
              <span  class="cMain">{{__('dashboard.projects')}}</span>
          </a>
        <?php endif; ?>
      </li>

      <li class="nav-item">
        <?php if(Route::currentRouteName() == 'library'): ?>
          <i class="c01 fas fa-photo-video "></i>
          <span  class="c01" style="cursor: default">{{__('dashboard.library')}}</span>
        <?php else: ?>
          <a class="nav-link cMain text-md-left"     href="{{ route('library') }}"><i class="fas fa-photo-video "></i>
              <span  class="cMain">{{__('dashboard.library')}}</span>
          </a>
        <?php endif; ?>
      </li>

      <li class="nav-item">
        <?php if(Route::currentRouteName() == 'crm'): ?>
          <i class="c01 fas fa-users  "></i>
          <span  class="c01" style="cursor: default">CRM</span>
        <?php else: ?>
          <a class="nav-link cMain text-md-left"     href="{{ route('crm') }}"><i class="fas fa-users "></i>
              <span  class="cMain">CRM</span>
          </a>
        <?php endif; ?>
      </li>
      <li class="nav-item">
        <?php if(Route::currentRouteName() == 'integrations.webhook'): ?>
          <i class="c01 fas fa-plug"></i>
          <span class="c01" style="cursor: default">{{__('integrations.integrations')}}</span>
          <div class="ml-4 mt-1 c01" style="font-size: 13px;">{{__('integrations.webhook')}}</div>
        <?php else: ?>
          <a class="nav-link cMain text-md-left" href="{{ route('integrations.webhook') }}"><i class="fas fa-plug"></i>
              <span class="cMain">{{__('integrations.integrations')}}</span>
          </a>
          <a class="nav-link cMain text-md-left ml-4 py-0" href="{{ route('integrations.webhook') }}" style="font-size: 13px;">
              <span class="cMain">{{__('integrations.webhook')}}</span>
          </a>
        <?php endif; ?>
      </li>
      <li class="nav-item">
        <?php if(Route::currentRouteName() == 'help'): ?>
          <i class="c01 fas fa-question-circle "></i>
          <span  class="c01" style="cursor: default">{{__('dashboard.help')}}</span>
        <?php else: ?>
          <a class="nav-link cMain text-md-left"     href='https://playfunnel.net/help' target="_blank"><i class="fas fa-question-circle "></i>
              <span  class="cMain">{{__('dashboard.help')}}</span>
          </a>
        <?php endif; ?>
      </li>
		<?php if (false)  { ?>
          <li class="nav-item">
            <?php if(Route::currentRouteName() == 'demo'): ?>
              <i class="c01 fas fa-cheese "></i>
              <span  class="c01" style="cursor: default">{{__('dashboard.demo')}}</span>
            <?php else: ?>
              <a class="nav-link cMain text-md-left"     href="javascript:alert('Pend. implemet.')"><i class="fas fa-cheese "></i>
                  <span  class="cMain">{{__('dashboard.demo')}}</span>
              </a>
            <?php endif; ?>
          </li>

          <li class="nav-item">
            <?php if(Route::currentRouteName() == 'config'): ?>
              <i class="c01 fas fa-cog"></i>
              <span  class="c01" style="cursor: default">{{__('dashboard.config')}}</span>
            <?php else: ?>
              <a class="nav-link cMain text-md-left"     href="javascript:alert('Pend. implemet.')"><i class="fas fa-cog"></i>
                  <span  class="cMain">{{__('dashboard.config')}}</span>
              </a>
            <?php endif; ?>
          </li>
		<?php } ?>

<!--
      <li class="nav-item">
        <a class="nav-link <?= (Route::currentRouteName() == 'projects') ? 'c01' : 'cMain' ?> text-md-left"     href="projects"><i class="fas fa-th-large "></i>
            <span  class="<?= (Route::currentRouteName() == 'projects') ? 'c01' : 'cMain' ?>">{{__('dashboard.projects')}}</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (Route::currentRouteName() == 'library') ? 'c01' : 'cMain' ?>  text-md-left"     href="library"><i class="fas fa-photo-video "></i>
            <span  class="<?= (Route::currentRouteName() == 'library') ? 'c01' : 'cMain' ?>">{{__('dashboard.library')}}</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (Route::currentRouteName() == 'crm') ? 'c01' : 'cMain' ?>  text-md-left"     href="crm"><i class="fas fa-users "></i>
            <span  class="<?= (Route::currentRouteName() == 'crm') ? 'c01' : 'cMain' ?>">CRM</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (Route::currentRouteName() == 'demo') ? 'c01' : 'cMain' ?>  text-md-left"     href="#"><i class="fas fa-cheese "></i>
            <span  class="<?= (Route::currentRouteName() == 'demo') ? 'c01' : 'cMain' ?>">{{__('dashboard.demo')}}</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (Route::currentRouteName() == 'help') ? 'c01' : 'cMain' ?>  text-md-left"     href="#"><i class="fas fa-question-circle "></i>
            <span class="<?= (Route::currentRouteName() == 'help') ? 'c01' : 'cMain' ?>">{{__('dashboard.help')}}</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (Route::currentRouteName() == 'config') ? 'c01' : 'cMain' ?>  text-md-left"     href="#"><i class="fas fa-cog "></i>
            <span class="<?= (Route::currentRouteName() == 'config') ? 'c01' : 'cMain' ?>">{{__('dashboard.config')}}</span></a>
      </li>
-->


    </ul>
</div>
