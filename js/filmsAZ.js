$(document).ready(function(){

    $.ajax({
        url:'../included/ajax/filmListAZ.php',
        data:{lang:lang},
        type:'GET',
        dataType: 'html',
        beforeSend: function(){
            $("#filmFilterAjaxContent").append("<div class='ajaxLoading'><img src='imgs/layout/loading.gif'> Loading...</div>").show(1000);
        },
        success: function(html, textSuccess){
            $("#filmFilterAjaxContent").html(html);

        },
        complete: function(){
        },
        error: function(xhr, textStatus, errorThrown){
            alert("Nastala chyba "+errorThrown);
        }
    });


    $(".filter").on("click",function(event){
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $("#elementtoScrollToID").offset().top
        }, 2000);


        type = $(this).attr("data-type");
        value = $(this).attr("data-value");
        lang = $(this).attr("data-lang");

        $.ajax({
            url:'../included/ajax/filmFilter.php',
            data:{type:type, value:value, lang:lang},
            type:'GET',
            dataType: 'html',
            beforeSend: function(){
                $("#filmFilterAjaxContent").append("<div class='ajaxLoading'><img src='imgs/layout/loading.gif'> Loading...</div>").show(1000);
            },
            success: function(html, textSuccess){
                $("#filmFilterAjaxContent").html(html);

            },
            complete: function(){
            },
            error: function(xhr, textStatus, errorThrown){
                alert("Nastala chyba "+errorThrown);
            }
        });
    });
});