

jQuery("#primary-menu li.menu-item-has-children").append('<i class="fa fa-angle-down" aria-hidden="true"></i>');


jQuery("li.menu-item-has-children>i").click(function () {
    jQuery(this).parent().children('ul').slideToggle();
});

jQuery(".menu-toggle").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById("wp-menu").style.width = "250px";
});

jQuery(".closebtn").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById("wp-menu").style.width = "0";
});
