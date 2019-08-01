<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$adminInfo=$_SESSION['adminInfo'];

?>
<section class="sidebar">
    <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo $adminInfo['avatar']?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php echo $adminInfo['nickname']?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
        </div>
    </div>
    <ul class="sidebar-menu">
        <li class="header">主导航</li>
        <?php

        foreach ($_SESSION['leftMenu'] as $menu) {
            $active = '';
            $class=ucfirst($this->uri->segment(1));
            $lclass=lcfirst($this->uri->segment(1));
           
            if (!empty($menu['items']) && !empty($class)) {
                foreach ($menu['items'] as $value) {
                    if (array_search($class, $value)||array_search($lclass, $value)) {
                        $active = 'active';
                    }
                }
            }
            ?>
            <?php if (empty($menu['items'])) { ?>
        <li class="<?php if ( !empty($class) && (array_search($class, $menu)||array_search($lclass, $menu))) echo 'active'; ?>" >
            <a href='<?php echo site_url( $menu['controller'] . "/" . $menu['method'])?>'>
                        <i class="fa fa-<?php echo empty($menu['icon']) ? 'th' : $menu['icon']; ?>"></i> <span><?php echo $menu['group'] ?></span>
                    </a>
                </li>
    <?php } else { ?>
                <li class="treeview <?php echo $active; ?>">
                    <a href="#">
                        <i class="fa fa-<?php echo empty($menu['icon']) ? 'laptop' : $menu['icon']; ?>"></i>
                        <span><?php echo $menu['group']
                    ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu menu-open">
                        <?php
                        foreach ($menu['items'] as $item) {
                            $active2 = '';
                            if (($item['method'] == $this->uri->segment(2)) && ($item['controller'] == $this->uri->segment(1))) {
                                $active2 = 'active';
                            }
                            ?>
                            <li class="<?php echo $active2; ?>">
                                <a href="<?php echo site_url( $item['controller'] . "/" . $item['method']) ?>"><i class="fa fa-<?php echo empty($item['icon']) ? 'circle-o' : $item['icon']; ?>"></i><?php echo $item['title'] ?></a>
                            </li>
                <?php } ?>
                    </ul>
                </li>
                <?php
            }
        }
        ?>

<!--        <li class="header">标签</li>
        <li>
            <a href="#"><i class="fa fa-circle-o text-red"></i> <span>重要</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>警告</span></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>信息</span></a>
        </li>-->
    </ul>
</section>
<!-- /.sidebar -->