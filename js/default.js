
$(document).ready(function(){

    // zobrazení ETR textů ////////////////////////////////////


        $('#etrButton').on('click', function(e) {
            e.preventDefault();
            $("#noETRContent").fadeOut();
            etr = $("#ETR").html();
            $("#ETRcontent").html(etr);
            $("#ETRcontent").fadeIn();
            $("#fullNoETRtext").show();
            $(this).hide();

        });
    // screenings pro postizene ////////////////////////////////////

        $(".limitedAccessGroup").click(function(){
            $(".limitedAccessGroupContent").slideToggle();
        });


    /*$('.tooltips').powerTip({placement: 's'});*/


    // odrolovat na newsletter form ////////////////////////////////////

    $("#slideToNewsletter").click(function(){
         $("html, body").animate({
             scrollTop: $("#registrationForm").offset().top
         }, 2000);
    });

    // form na newsletter na home //////////////////////////////////////


        $(".call").click(function(){
            if($(this).attr("value") == "ne"){
                $("#registrationFormExtraFields").slideUp();
            }else{
                $("#registrationFormExtraFields").slideDown();
            }
        });


	// uprava regionů //////////////////////////////////////////////////////////////////////////////////////////////
	$(".wideMenuRegions li:eq(0)").remove();
	$(".wideMenuRegions .parent-link").remove();
	
	// add screening to visitor program //////////////////////////////////////////////////////////////////////
	$(".addToProgram").click(function(){
		screeningId = $(this).attr("data-screeningId");
		lang = $(this).attr("data-lang");
		$.ajax({
			url:'../included/ajax/addScreeningToVisitorProgram.php', 
			data:{screeningId:screeningId, lang:lang},
			type:'GET',  
			dataType: 'html',
			beforeSend: function(){
				$("#ajaxVisitorProgramContent").append("<div class='ajaxLoading'><img src='imgs/ajax-loader.gif'> Loading...</div>").show(1000);
			},
			success: function(html, textSuccess){
				$("#ajaxVisitorProgramContent").html(html);
				$('#visitorProgamModal').foundation('reveal', 'open');
			},
			complete: function(){
			},
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba "+errorThrown);
			}
		});
	});
	
	// film short detail //////////////////////////////////////////////////////////////////////
	$(".filmDetail").click(function(event){ 
		event.preventDefault();
		$(".filmDetailContent").slideUp();
		$("tr").removeClass("active");
        $(".fullFilmTitle").css("color","#222");
		$(".fullFilmTitle a").css("color","#007fff");
		filmId = $(this).attr("data-filmId");
		screenId = $(this).attr("data-screenId");
		lang = $(this).attr("data-lang");

		var tr = $(this).parent().parent();
		$("#s"+screenId).css("display","table-row");
		//$(this).replaceWith( "<span class='filmTitle'>" + $(this).text() + "</span>" );
		$(this).css("color","#eee");
        $(this).parent().css("color","#eee");
		tr.addClass("active");
		$.ajax({
			url:'../included/ajax/filmDetail.php', 
			data:{filmId:filmId, screenId:screenId, lang:lang},
			type:'GET',  
			dataType: 'html',
			beforeSend: function(){
				$("#s"+screenId+" .ajaxContent").append("<div class='ajaxLoading'><img src='imgs/ajax-loader.gif'> Loading...</div>").show(1000);
			},
			success: function(html, textSuccess){
				$("#s"+screenId+" .ajaxContent").html(html);
				
			},
			complete: function(){
			},
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba "+errorThrown);
			}
		});
	});
	
	// film short detail region //////////////////////////////////////////////////////////////////////
	$(".filmDetailRegion").click(function(event){ 
		event.preventDefault();
		$(".filmDetailContent").slideUp();
		$("tr").removeClass("active");
		$(".filmTitle").fadeIn("");
		filmId = $(this).attr("data-filmId");
		screenId = $(this).attr("data-screenId");
		lang = $(this).attr("data-lang");

		var tr = $(this).parent().parent();
		$("#s"+screenId).css("display","table-row");
		//$(this).replaceWith( "<span class='filmTitle'>" + $(this).text() + "</span>" );
		$(this).fadeOut();
		tr.addClass("active");
		$.ajax({
			url:'../included/ajax/filmDetail.php', 
			data:{filmId:filmId, screenId:screenId, lang:lang},
			type:'GET',  
			dataType: 'html',
			beforeSend: function(){
				$("#s"+screenId+" .ajaxContent").append("<div class='ajaxLoading'><img src='imgs/ajax-loader.gif'> Loading...</div>").show(1000);
			},
			success: function(html, textSuccess){
				$("#s"+screenId+" .ajaxContent").html(html);
				
			},
			complete: function(){
			},
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba "+errorThrown);
			}
		});
	});
	// film short detail brussel //////////////////////////////////////////////////////////////////////
	$(".filmDetailBrussel").click(function(event){ 
		event.preventDefault();
		$(".filmDetailContent").slideUp();
		$("tr").removeClass("active");
		$(".filmTitle").fadeIn("");
		filmId = $(this).attr("data-filmId");
		screenId = $(this).attr("data-screenId");
		lang = $(this).attr("data-lang");

		var tr = $(this).parent().parent();
		$("#s"+screenId).css("display","table-row");
		//$(this).replaceWith( "<span class='filmTitle'>" + $(this).text() + "</span>" );
		$(this).fadeOut();
		tr.addClass("active");
		$.ajax({
			url:'../included/ajax/brusselFilmDetail.php', 
			data:{filmId:filmId, screenId:screenId, lang:lang},
			type:'GET',  
			dataType: 'html',
			beforeSend: function(){
				$("#s"+screenId+" .ajaxContent").append("<div class='ajaxLoading'><img src='imgs/ajax-loader.gif'> Loading...</div>").show(1000);
			},
			success: function(html, textSuccess){
				$("#s"+screenId+" .ajaxContent").html(html);
				
			},
			complete: function(){
			},
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba "+errorThrown);
			}
		});
	});
	
});