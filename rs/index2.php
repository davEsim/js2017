<?php
ini_set('display_errors',0); 
ini_set('display_startup_errors',1);
error_reporting(-1); // ukaze opravdu vse
//error_reporting(E-ALL);
session_name("rsOW2016");
session_start();
//print_r($_SESSION);
//$userTest=$_SESSION["userFullName"]; 
include_once("./php/mysql.class.php");
include_once("./php/connection.php");  
include_once("./php/login.class.php");
include_once("./php/funcs.php");
$_ENV["sysTables"]="'groups','users', 'usersCompany', 'xCountry', 'xCategory', 'xCategory2', 'xLanguage', 'xKeys'";
$_ENV["langs"]=array("CZ", "EN");
//$_ENV["noLang"]="CZ"; // pokud chci CZ i EN, prostě nenastavovat
//$_ENV["prefLang"]="EN";
if (!IsSet($_SESSION["limit"])) $_SESSION["limit"]=10; 
?>  
<!DOCTYPE html>
<html> 
<head>
<meta charset="utf-8">
<title>JS2017 - CMS</title> 
<link href="jQuery-File-Upload/uploadfile.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="layout/rs.css" rel="stylesheet" type="text/css">
<style type="text/css" media="print">
	.noPrint{display:none}
</style>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.friendurl.js"></script>
<script src="jQuery-File-Upload/jquery.uploadfile.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script> 
<script src="ckeditor/ckeditor.js"></script>
<script type="text/javascript"  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWTwlOE3H0RIRKbjzry9u1jbpy4jw9kHM"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script>
  $(function() {
	$( ".datepicker" ).datepicker();
	$( ".datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
  });
</script>
<script>
$(function() {
    $(".help").tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  });
  </script>
  <style>
  a.help{
	background-color:#0394af;
	color:white;
	font-weight:bold;
	padding:1px 4px;  
  }
  .ui-tooltip, .arrow:after {
    background: #cfcfcf;
    border: 2px solid white;
  }
  .ui-tooltip {
    padding: 10px 20px;
    color: white;
    border-radius: 20px;
    font:  14px "Helvetica Neue", Sans-Serif;
    box-shadow: 0 0 3px gray;
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 30%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 50%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    tranform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  h5{
	padding-left:2em;  
  }
  </style>
</head>
<body>  
<?php
$login = new Login;
if($_POST["login"] && $_POST["psswd"])
{
	$correctLogIn = $login->first_login();	
}else{
	$correctLogIn = $login->logged();
}
if($_GET["logout"]==1){
	$login->logout();
	$correctLogIn=false;	
}
if($correctLogIn) 
{
	include_once("./php/config.php");
	
?>
<div id="menu" class="noPrint">
	<a href="https://<?=$_SERVER['HTTP_HOST']?>/2016/rs"><div id="logo">JS2017 - CMS</div></a>
    <ul>
	  <?
	  if($_ENV["userIsAdmin"]) $mysql="";else $mysql="AND tableDbName IN ('$_ENV[userAllowedTablesIN]')" ;
      $sql->query('tables', "SELECT * FROM flagsTables WHERE tableDbName NOT IN ($_ENV[sysTables]) $mysql ORDER BY tableWebName");
      while($row=$sql->fetch_assoc('tables')):
          echo "<li><a href='".$_SERVER['PHP_SELF']."?action=list&amp;page=tableItem&amp;table=".$row["tableDbName"]."'>".$row["tableWebName"]."</a></li>";		
      endwhile;	
      ?>
    </ul>
    <? if($_ENV["userIsAdmin"]){?>
      <ul>
        <?
        $sql->query('tables', "SELECT * FROM flagsTables WHERE tableDbName IN ($_ENV[sysTables]) AND tableDbName NOT LIKE 'rspages' ORDER BY tableWebName");
        while($row=$sql->fetch_assoc('tables')):
            echo "<li><a href='".$_SERVER['PHP_SELF']."?action=list&amp;page=tableItem&amp;table=".$row["tableDbName"]."'>".$row["tableWebName"]."</a></li>";		
        endwhile;	 
        ?>
      </ul>
    	<h4><a href="index2.php?page=pages" >Stránky</a></h4>
    	<h4><a href="index2.php?page=pagesRegions" >Stránky - regiony</a></h4>
        <hr><br>
        <h5><a href="index2.php?page=regionsTaxFee" >Vstupenky - vkládání</a></h5>
        <h5><a href="index2.php?page=regionsTaxFeeStatistics" >Vstupenky - fakturace</a></h5>
        <br>
    <? }elseif($_SESSION["userId"] == 96){?>
        <h5><a href="index2.php?page=regionsTaxFee" >Vstupenky - vkládání</a></h5>    	 
    <? }else{?> 
    	<h4><a href="index2.php?page=pagesRegions" >Stránky - Regiony</a></h4>
    <? }?>
    <p class="right user"><?=$_SESSION["userFullName"] ?></p>
    <p class="right logout"><a  href="<?=$_SERVER['PHP_SELF']."?logout=1"?>">Logout</a></p>
</div>
<div id="main">
	<?php
    if ($_GET["page"]=="tableItem"){ 
		if ($_ENV["userRightsError"]!="") 
			echo "<p class='warning'>".$_ENV["userRightsError"]."</p>";
		else 
			include("$_GET[page].php"); 
	}
   	else{
		include("$_GET[page].php"); 
	}
	if(!$_GET["page"]){
		$rInfo=MySQL_Fetch_Array(MySQL_Query("SELECT * FROM rspages WHERE nameEN LIKE 'root'"));
		echo "<div style='width:500px;'>";
		echo $rInfo["contentEN"];
		echo "</div>";	
	}
     ?>
</div>
<?
}elseif($_GET["logout"]!=1){ //!$_POST && !$logStatus
?>
	<form method="post" id="logInForm" style="noCss" action="<?=$_SERVER['PHP_SELF']?>">
    	<!--<div id="logInLogo"></div>-->
    	<table>
          <tr><th>Login:</th><td><input type="text" name="login" /></td></tr>
          <tr><th>Password:</th><td><input type="password" name="psswd" /></td></tr>
          <tr class="noCss"><td colspan="2" class="center"><input type="submit" value="Log In" /></td></tr>
         </table>
        
    </form>
<?
}else{	//!$_POST && !$logStatus
	?>
    	<form id="logInForm">
        	<div>
            	<p>Odhlášení proběhlo korektně.</p>
        		<p><a href="<?=$_SERVER['PHP_SELF']?>">Znovu přihlásit</a></p>
            </div> 
        </form>
    <?
}
?>
<script>
// ------ AJAX media --------------------------------------------------------------------------------

$(document).ready(function() { 

// ------------------- pages ------------------------------------------------------------------------
	function ajaxPages(){
		id=$(this).attr("data-pageid");
		parent=$(this).attr("data-parent");
		position=$(this).attr("data-position");
		action=$(this).attr("data-action");
		newposition=$(this).attr("data-newposition");
		$.ajax({
			url:'<?=($_GET["page"]=="pagesRegions")?$_GET["page"]:"pages"?>.php', 
			data:{id:id, parent:parent, position:position, action:action, newposition:newposition},
			type:'GET',
			dataType: 'html',
			/*beforeSend: function(){
				info="#info"+ids;
				$(info).append("<div class='ajaxLoading'></div>").show(1000);
			},*/
			success: function(html, textSuccess){
				$("#tree").html(html);
				$(".deletePage").click(ajaxPages);
				$(".stepUpPage").click(ajaxPages);
			},
			/*complete: function(){
				al="#ajaxLoading"+ids;
				$(al).hide();
			},*/
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba"+errorThrown);
			}
		});
	}
	$(".deletePage").click(ajaxPages);
	$(".stepUpPage").click(ajaxPages);
	
// ------------------- friend url ------------------------------------------------------------------------
		
	<? if($_REQUEST["action"]=="insert"){?>	
	$('#nameCZ').friendurl({id : 'seoUrlCZ', divider: '-', transliterate: true});
	$('#name_fullCZ').friendurl({id : 'seoUrlCZ', divider: '-', transliterate: true});
	$('#nameEN').friendurl({id : 'seoUrlEN', divider: '-', transliterate: true});
	$('#name_fullEN').friendurl({id : 'seoUrlEN', divider: '-', transliterate: true});
	<? }?>

// ------------------- move and edit ------------------------------------------------------------------------
	function changeOnImg(){
		imgid=$(this).attr("data-imgid");
		inputid="#newImgName_"+imgid;
		newimgname=$(inputid).val();
		imgaction=$(this).attr("data-imgaction");
		imgposition=$(this).attr("data-imgposition"); 
		table=$(this).attr("data-table");
		id=$(this).attr("data-id");
		flagtableid=$(this).attr("data-flagtableid");
		$.ajax({
			url:'imgs.php', 
			data:{imgid:imgid, imgaction:imgaction, imgposition:imgposition, table:table, id:id, flagtableid:flagtableid, newimgname:newimgname},
			type:'GET',
			dataType: 'html',
			success: function(html, textSuccess){
				$("#media").html(html);
				//$(".delImg").on("click", delImg);
				$(".changeOnImg").on("click", changeOnImg);
				$(".submitChangeImgName").click(function(){
					$(this).next("div").css("display","block");
				});
			},
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba"+errorThrown);
			}
		});
	}
    function changeOnDoc(){
        docid=$(this).attr("data-docid");
        inputid="#newDocName_"+docid;
        newdocname=$(inputid).val();
        docaction=$(this).attr("data-docaction");
        docposition=$(this).attr("data-docposition");
        table=$(this).attr("data-table");
        id=$(this).attr("data-id");
        flagtableid=$(this).attr("data-flagtableid");
        $.ajax({
            url:'docs.php',
            data:{docid:docid, docaction:docaction, docposition:docposition, table:table, id:id, flagtableid:flagtableid, newdocname:newdocname},
            type:'GET',
            dataType: 'html',
            success: function(html, textSuccess){
                $("#media").html(html);
                //$(".delImg").on("click", delImg);
                $(".changeOnDoc").on("click", changeOnDoc);
                $(".submitChangeDocName").click(function(){
                    $(this).next("div").css("display","block");
                });
            },
            error: function(xhr, textStatus, errorThrown){
                alert("Nastala chyba"+errorThrown);
            }
        });
    }

// ------------------- upload ------------------------------------------------------------------------

var settings = {
    url: "https://<?=$_SERVER['HTTP_HOST']?>/2017/rs/jQuery-File-Upload/upload.php",
    dragDrop:true,
    fileName: "insertedMediaFile",
	autoSubmit:true,
	multiple:true,
	showStatusAfterSuccess:false,
    allowedTypes:"jpg,jpeg,png,gif,pdf,doc,docx",
	/*maxFileSize:1024*100,*/	
    returnType:"html",
	dynamicFormData: function()
	  {
		  title=$("#insertedMediaTitle").val();	
		  var data ={table: "<?=$_GET["table"]?>", id: <?=($_GET["id"])?$_GET["id"]:0?>, fileTitle:title}
		  return data;
	  },
	onSuccess:function(files,data,xhr)
    {
        //alert((data));
		$("#media").html(data);
		$(".changeOnImg").on("click",changeOnImg);
		$(".submitChangeImgName").click(function(){
			$(this).next("div").css("display","block");
		});
        $(".changeOnDoc").on("click",changeOnDoc);
    },
    showDelete:true,
    deleteCallback: function(data,pd)
	{
    for(var i=0;i<data.length;i++)
    {
        $.post("delete.php",{op:"delete",name:data[i]},
        function(resp, textStatus, jqXHR)
        {
            //Show Message  
            $("#status").append("<div>File Deleted</div>");      
        });
     }      
    pd.statusbar.hide(); //You choice to hide/not.
}
}
	$("#mediaFileUploader").uploadFile(settings);
	$(".changeOnImg").click(changeOnImg);
	$(".submitChangeImgName").click(function(){
		$(this).next("div").css("display","block");
	});
    $(".changeOnDoc").on("click",changeOnDoc);
});
</script>
</body>
</html>
