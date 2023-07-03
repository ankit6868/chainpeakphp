<?php
    header("Content-Type:text/css");
    function checkhexcolor($color){
        return preg_match('/^#[a-f0-9]{6}$/i', $color);
    }

    if (isset($_GET['color']) AND $_GET['color'] != '') {
        $color = "#" . $_GET['color'];
    }

    if (!$color OR !checkhexcolor($color)) {
        $color = "#336699";
    }

    if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
        $secondColor = "#" . $_GET['secondColor'];
    }

    if (!$secondColor OR !checkhexcolor($secondColor)) {
        $secondColor = "#336699";
    }
?>

.btn--base, .add-item .add-header, .view-btn-list li.active .list-btn, .search-from button, .search-from input[type="button"], .search-from input[type="reset"], .search-from input[type="submit"], .btn--base.active:focus, .btn--base.active:hover, .custom-check-group input:checked + label::before, .slider-next, .slider-prev, .nav-tabs .nav-link.active, .item-review-widget-wrapper .left, .submit-btn, .reply-btn, .coupon-form .coupon-form-btn, .blog-thumb .blog-date, .blog-social-area .blog-social li:hover, .input-group-text, .category-item-content .title, .item-card .item-card-thumb .item-level, .ui-slider-range, .ui-state-default, .bg--base, .image-upload .thumb .avatar-edit label,.dashboard-sidebar-open, .dashboard-sidebar-close{
    background: <?php echo $color ?>;
    background: -webkit-linear-gradient(legacy-direction(to right),  <?php echo $color ?> 0%, <?php echo $secondColor ?> 100%);
    background: -webkit-gradient(linear, left top, right top, from( <?php echo $color ?>), to(<?php echo $secondColor ?>));
    background: -webkit-linear-gradient(left, <?php echo $color ?> 0%, <?php echo $secondColor ?> 100%);
    background: -o-linear-gradient(left, <?php echo $color ?> 0%, <?php echo $secondColor ?> 100%);
    background: linear-gradient(to right, <?php echo $color ?> 0%, <?php echo $secondColor ?> 100%);
}

.view-btn-list li.active .list-btn, .btn--base.active:focus, .btn--base.active:hover, .item-details-footer .footer-social li a:hover, .item-details-footer .footer-social li a.active, .blog-social-area .blog-social li:hover{
    border-color: <?php echo $color ?>;
}

.item-card-content-top .author-content .name .level-text, .item-card-content-top .right .item-amount, .item-card-footer .item-like i, .item-card-title a:hover, .category-list li:hover::before, .category-list li:hover, .header-bottom-area .navbar-collapse .main-menu li a:hover, .header-bottom-area .navbar-collapse .main-menu li a.active, .footer-links li:hover, .footer-links li:hover::before, .breadcrumb-item a, .breadcrumb-item.active::before, .blog-content-inner .title a:hover, .short-menu li:hover, .sidebar-main-menu li a:hover, .navbar-toggler span{
    color: <?php echo $color ?>;
}

.text--base {
    color: <?php echo $color ?> !important;
}


.header-bottom-area .navbar-collapse .main-menu li a::after, .item-details-footer .item-like, .footer-social li a:hover, .footer-social li a.active, .subscribe-form button, .subscribe-form input[type="button"], .subscribe-form input[type="reset"], .subscribe-form input[type="submit"], .short-menu-open-btn, .short-menu-close-btn, *::-webkit-scrollbar-button, *::-webkit-scrollbar-thumb, .chosen-container .chosen-results li.highlighted, ::selection {
    background-color: <?php echo $color ?>;
}



.buy-btn {
    border: 1px solid <?php echo $color ?> !important;
    color: <?php echo $color ?> !important;
}

.date-btn {
    border: 1px solid <?php echo $color ?> !important;
    color: <?php echo $color ?> !important;
}

.contact-info-icon i {
    background-color: <?php echo $color ?>;
}

.sidebar-main-menu li.open a {
    background-color: rgba(255, 255, 255, 0.1);
    color: <?php echo $color ?>;
    border-left: 2px solid <?php echo $color ?>;
}

.pagination .page-item.active .page-link, .pagination .page-item:hover .page-link, .item-tags a:hover {
    background: <?php echo $color ?>;
    border-color: <?php echo $color ?>;
    color: white;
}

.btn--base:focus, .btn--base:hover {
  
  box-shadow: 0 10px 20px <?php echo $color ?>40;
}

.ui-widget.ui-widget-content::after{
    background-color: <?php echo $color ?>20;
}

.path {
    stroke: <?php echo $color ?>;
}

@keyframes color {
  0% {
    stroke: <?php echo $color ?>;
  }

  100% {
    stroke: <?php echo $color ?>;
  }
}

.follow-btn a {
    border: 1px solid <?php echo $color ?> !important;
    color: <?php echo $color ?> !important;
}


.pagination .page-item.disabled span {
    background: <?php echo $color ?>66;

}

