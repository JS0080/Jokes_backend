                    <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper" style="margin-bottom: 15px !important;">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler">
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>

<?php if ($page_name=='admob')   { ?>
                        <li class="active open">
                            <a href="<?php echo $basePath;?>user/admob.html">
                                <i class="fa fa-film"></i>
                                <span class="title">Admob</span>
                                <span class="selected"></span>
                            </a>
                        </li>
<?php } else { ?>                        
                        <li class="">
                            <a href="<?php echo $basePath;?>user/admob.html">
                                <i class="fa fa-film"></i>
                                <span class="title">Admob</span>
                            </a>
                        </li>
<?php } ?>    

                        
<?php if ($page_name=='quotes')   { ?>
                        <li class="active open">
                            <a href="<?php echo $basePath;?>quotes/index.html">
                                <i class="fa fa-file-text-o"></i>
                                <span class="title">Quotes</span>
                                <span class="selected"></span>
                            </a>
                        </li>
<?php } else { ?>                        
                        <li class="">
                            <a href="<?php echo $basePath;?>quotes/index.html">
                                <i class="fa fa-file-text-o"></i>
                                <span class="title">Quotes</span>
                            </a>
                        </li>
<?php } ?>    
                        
 <?php if ($page_name=='likes')   { ?>
                        <li class="active open">
                            <a href="<?php echo $basePath;?>quotes/likes.html">
                                <i class="fa fa-heart-o"></i>
                                <span class="title">Like/Dislike</span>
                                <span class="selected"></span>
                            </a>
                        </li>
<?php } else { ?>                        
                        <li class="">
                            <a href="<?php echo $basePath;?>quotes/likes.html">
                                <i class="fa fa-heart-o"></i>
                                <span class="title">Like/Dislike</span>
                            </a>
                        </li>
<?php } ?>                        

<?php if ($page_name=='profile')   { ?>
                        <li class="active open">
                            <a href="<?php echo $basePath;?>user/profile.html">
                                <i class="icon-user"></i>
                                <span class="title">Profile</span>
                                <span class="selected"></span>
                            </a>
                        </li>
<?php } else { ?>                        
                        <li class="">
                            <a href="<?php echo $basePath;?>user/profile.html">
                                <i class="icon-user"></i>
                                <span class="title">Profile</span>
                            </a>
                        </li>
<?php } ?>                        
                        
                    </ul>
