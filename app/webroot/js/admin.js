$(function () {
    $('*[rel="tooltip"]').tooltip()
    $('*[rel="tooltip-bottom"]').tooltip({
        placement: "bottom"
    })
    $(".time").setMask('time');

    var listItem = $('#accordion > div > div > ul > li.active').parent().parent().addClass('active-accordion')
    var Index = $('#accordion > div > div').index(listItem)
    $('#accordion > div').each(function(i){
        if (i==Index){
            $(this).accordion({active: 0, heightStyle: "content" ,collapsible: true});
        }else {
            $(this).accordion({active: false, heightStyle: "content" ,collapsible: true});
        }
    })

	$('.navbar-inner li.dropdown .dropdown-menu').hover(function(){
		$(this).closest('.navbar-inner li.dropdown').addClass('open');
	}, function(){
		$(this).closest('.navbar-inner li.dropdown').removeClass('open');
	});

    $('.date').datepicker({
        dateFormat: "dd.mm.yy",
        buttonImage: "/img/icons/calendar.png",
        showOn: "button",
        buttonImageOnly: true,
        changeYear: true,
        changeMonth: true
    });

    $('ul.nav.nav-tabs > li > a').click(function(){
    	var tab = $(this).parent().get(0).id.replace(/tab\-/, '');
    	$('ul.nav.nav-tabs > li').removeClass('active');
    	$('ul.nav.nav-tabs > #tab-' + tab).addClass('active');
    	$('.tab-content-all .tab-content').hide();
    	$('.tab-content-all #tab-content-' + tab).show();
    });

    $('.open-fieldset').on('click', function () {
        var content = $(this).parent().next('.fieldset-content')
        if (content.is(':visible')) {
            content.hide(200);
            $(this).children('i').removeClass('opened');
        } else {
            content.show(200);
            $(this).children('i').addClass('opened');
        }
        return false;
    })

    $('.show-popover-content').popover({
        html: true,
        placement: 'bottom',
        trigger: "hover",
        content: function () {
            return $(this).next('.popover-content').html();
        }
    });
})
