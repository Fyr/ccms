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
    /*
    $('.date').datepicker({
        dateFormat: "dd.mm.yy",
        buttonImage: "img/calendar.png",
        showOn: "button",
        buttonImageOnly: true,
        changeYear: true
    })
    */
/*
    var filter_is_visible = true
    $('#show-filter').on('click', function () {
        if (filter_is_visible) {
            $('#greed-filter').show()
        }
        else {
            $('#greed-filter').hide()
        }
        filter_is_visible = !filter_is_visible
        return false
    })
*/
    $('.open-fieldset').on('click', function () {
        var content = $(this).parent().next('.fieldset-content')
        if (content.is(':visible')) {
            content.hide(200)
            $(this).children('i').removeClass('opened')
        }
        else {
            content.show(200)
            $(this).children('i').addClass('opened')
        }
        return false
    })

    $('.show-popover-content').popover({
        html: true,
        placement: 'bottom',
        trigger: "hover",
        content: function () {
            return $(this).next('.popover-content').html()
        }
    })
    /*
    var checkAll = true
    var check = $('.checkthis')
    var total = check.length
    check.on('change', function () {
        var wordCheck
        if (checkAll){
             wordCheck = "Check "
        }
        else {
            wordCheck = "Uncheck "
        }
        var checked = 0;
        var text, text2
        $('#do-anithing').hide()
        check.each(function () {
            if ($(this).prop('checked')) {
                checked++
            }
        })

        if (checked > 0) {
            $('#do-anithing').show()
            text = "Выбрано <strong>" + checked + "</strong> из <strong>" + total + "</strong>"
            text2 = wordCheck + total + " records (" + checked + " checked)"

        }
        if (checked == 0) {
            $('#do-anithing').hide()
            text2 = "Check " + total + " records"
        }
        if (checked == total){
            text2 = wordCheck + total + " records"
        }
        $('#do-anithing small').html(text)
        $('.grid-chbx-select-all').attr('data-original-title', text2)
        Highlighted()
    })

   $('.grid-chbx-select-all').on('change',function(){
        if ($(this).prop('checked')) {
            check.each(function(){
                $(this).prop('checked', true)
            })
            checkAll = false
        }
       else {
            check.each(function(){
                $(this).prop('checked',false)
            })
            checkAll = true
        }
       check.change();
       Highlighted()
       $(this).tooltip('show');
   })
   */

})
/*
function Highlighted(){
   $('.checkthis').each(function(){
       if ($(this).prop("checked")){
           $(this).parents('tr').addClass('seleted')
       }
       else {
           $(this).parents('tr').removeClass('seleted')
       }
   })
}
*/