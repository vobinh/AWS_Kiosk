<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
	      	<li class="">
	      		<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	      			<img src="<?php echo $this->site['theme_url']?>images/user.png" alt=""><?php echo $this->sess_cus['name']; ?>
	      			<span class=" fa fa-angle-down"></span>
	      		</a>
	      		<ul class="dropdown-menu dropdown-usermenu pull-right">
	      			<li><a href="javascript:;"> Profile</a></li>
	      			<li>
	      				<a href="javascript:;">
	      					<span class="badge bg-red pull-right">50%</span>
	      					<span>Settings</span>
	      				</a>
	      			</li>
	      			<li><a href="javascript:;">Help</a></li>
	      			<li><a href="<?php echo url::base()  ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
	      		</ul>
	      	</li>
	      	<li class="dropdown dropdown-language">
	      		<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
	      			<img alt="" src="<?php echo $this->site['theme_url']?>images/flags/<?php echo $this->sess_cus['lang_code'] ?>.png">
	      			<span class="langname">
	      				<?php echo $this->site['languages'][$this->sess_cus['lang_code']] ?> </span>
	      				<i class="fa fa-angle-down"></i>
	      		</a>
      			<ul class="dropdown-menu dropdown-menu-default">
      				<?php if(!empty($this->site['languages'])): ?>
	      				<?php foreach ($this->site['languages'] as $key => $value): ?>
		      				<li>
		      					<a href="<?php echo url::base() ?>home/setlanguages/<?php echo $key ?>">
		      						<img alt="" src="<?php echo $this->site['theme_url']?>images/flags/<?php echo $key ?>.png"><span class="langname"> <?php echo $value ?></span>
		      					</a>
		      				</li>
		      			<?php endforeach; ?>
      				<?php endif; ?>
      			</ul>
      		</li>
      	</ul>
    </nav>
  </div>
</div>