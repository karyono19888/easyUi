<?php
$connect = mysqli_connect('localhost','root','','wh');
$query = mysqli_query($connect, 'select a_user_username,a_user_level from a_user where a_user_username = "'.$this->session->userdata("nama").'"');
$result = mysqli_fetch_assoc($query);
$l = $result['a_user_level'];
?>
<!DOCTYPE html>
<html>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(''); ?>" class="brand-link">
      <img src="<?=base_url('assets/adminlte/dist/img/AdminLTELogo.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
<!--
  <div class="image">
          <a href="<?php echo base_url(''); ?>"><img src="<?=base_url('assets/adminlte/dist/img/user2-160x160.jpg')?>" class="img-circle elevation-2" alt="User Image"></a>
        </div>
        <div class="info">
          <a href="<?php echo base_url(''); ?>" class="d-block">Alexander Pierce</a>
        </div>
-->
    <!-- Sidebar -->
    <div class="sidebar">

      <a href="#" class="brand-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?=base_url('assets/adminlte/dist/img/user2-160x160.jpg')?>" class="img-circle elevation-2" width="15%" alt="User Image">
        <span class="hidden-xs"><?php echo $this->session->userdata("nama"); ?></span>

      </a>
      <ul class="dropdown-menu">
        <li class="user-footer">
          <div class="pull-right">
            <a href="<?php echo base_url('Main/logout2'); ?>" class="btn btn-default btn-flat">Sign out</a>
          </div>
        </li>
      </ul>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
        <?php
          // data main menu
           # code...  
           $main_menu = $this->db->query('SELECT a_group_tes.*,
                                                 a_menu_tes.*,
                                                 a_user.*
                                            FROM a_group_tes LEFT JOIN a_menu_tes ON a_group_tes.a_group_menu = a_menu_tes.a_menu_id
                                                     LEFT JOIN a_user ON a_user.a_user_level = a_group_tes.a_group_level
                                            WHERE a_menu_tes.a_is_menu_main = 0 AND a_group_tes.a_group_status = 1 and a_user.a_user_level = '.$l.' GROUP BY a_menu_tes.a_menu_id');

            foreach ($main_menu->result() as $main) {
                // Query untuk mencari data sub menu
              //  $sub_menu = $this->db->query('SELECT * from a_menu_tes where a_is_menu_main = "'.$main->a_menu_id.'"');
               $sub_menu = $this->db->query('SELECT a_group_tes.*,
                                                 a_menu_tes.*,
                                                 a_user.*
                                            FROM a_group_tes LEFT JOIN a_menu_tes ON a_group_tes.a_group_menu = a_menu_tes.a_menu_id
                                                     LEFT JOIN a_user ON a_user.a_user_level = a_group_tes.a_group_level
                                            WHERE a_menu_tes.a_is_menu_main = "'.$main->a_menu_id.'" AND a_group_tes.a_group_status = 1 and a_user.a_user_level = '.$l.' GROUP BY a_menu_tes.a_menu_id');
                // periksa apakah ada sub menu
                if ($sub_menu->num_rows() > 0) {
                    // main menu dengan sub menu
                    echo "<li class='nav-item has-treeview'>
                          " . anchor($main->a_menu_link, '<a href="#" class="nav-link"><i class="' . $main->a_menu_icon . '"></i>' . $main->a_menu_name .
                            '<span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>');
                              echo "</a>";
                    // sub menu nya disini
                    echo "<ul class='nav nav-treeview'>";
                    foreach ($sub_menu->result() as $sub) {
                        echo "<li class='nav-item has-treeview'><div class='nav-link'>" . anchor($sub->a_menu_link, '<i class="' . $sub->a_menu_icon . '"></i>' . $sub->a_menu_name) . "</div></li>";
                    }
                    echo"</ul></li>";
                } else {
                    // main menu tanpa sub menu
                    echo "<li class='nav-item has-treeview'><div class='nav-link'>" . anchor($main->a_menu_link, '<i class="' . $main->a_menu_icon . '"></i>' . $main->a_menu_name) . "</div></li>";
                }
            }
          
            ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  
  </div>
  <!-- /.content-wrapper -->
  
</body>
</html>