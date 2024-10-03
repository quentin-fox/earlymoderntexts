<?php

// include 'conn.php';


include 'Frame.php';
$page_name = basename($_SERVER['REQUEST_URI']);
$frame = new Frame();

$frame->route('/', 'home');
$frame->route('/texts', 'texts');
$frame->route('/authors/(.*)', 'authors');
$frame->route('/faqs', 'faqs');
$frame->route('/faqss', 'faqs');
$frame->route('/faqs/(.*)', 'answer');
$frame->route('/bennett/(.*)', 'bennett');
$frame->route('/comments', 'comments');
$frame->route('/contact', 'contact');
$frame->route('/contactme', 'contact');
$frame->route('/audio', 'audio');
$frame->route('/mwaudio', 'mwaudio');
$frame->route('/dhaudio', 'dhaudio');
$frame->route('/rdaudio', 'rdaudio');
$frame->route('/jsmaudio', 'jsmaudio');
$frame->route('/jlaudio', 'jlaudio');
$frame->route('/thaudio', 'thaudio');
$frame->route('/th2audio', 'th2audio');
$frame->route('/search', 'search');
$frame->route('/sdgaudio', 'sdgaudio');
$frame->route('/gwlaudio', 'gwlaudio');
$frame->route('/anneconwayaudio', 'anneconwayaudio');
$frame->route('/rousseauaudio', 'rousseauaudio');
$frame->route('/nicolasaudio', 'nicolasaudio');
$frame->route('/machiavelli', 'machiavelli');
$frame->route('/edmund', 'edmund');

include 'Controller.php';

$frame->run();
?>

<input type="hidden" id="current_page_name" value="<?php echo $page_name; ?>">
<script type="text/javascript" src="/assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	// Get all files couts

	jQuery(document).ready(function () {
		// Selected nav bar
		var page_name = "";
			page_name = jQuery("#current_page_name").val();
		if(page_name == "audio" || page_name == "mwaudio" || page_name == "dhaudio" || page_name == "rdaudio" || page_name == "thaudio" || page_name == "th2audio" || page_name == "jlaudio" || page_name == "sdgaudio" || page_name == "gwlaudio" || page_name == "anneconwayaudio" || page_name == "rousseauaudio" || page_name == "nicolasaudio" || page_name == "machiavelli" || page_name == "edmund")
			jQuery("#audio_selected").addClass("selected");
		else if(page_name == "contactme")
			jQuery("#contact_selected").addClass("selected");
		else if(page_name == "comments")
			jQuery("#comments_selected").addClass("selected");
		else if(page_name == "faqss" || page_name == "formats")
			jQuery("#faqs_selected").addClass("selected");
		else if(page_name == "texts")
			jQuery("#texts_selected").addClass("selected");
		else
			jQuery("#home_selected").addClass("selected");
		// Get page counts
		// jQuery(".get_page_name").click(function (){
		// 	var href 		= $(this).attr('href');
		// 	var file_type 	= "2";
		// 	var title 		= $(this).attr('title');
		// 	$.ajax({
  //             url: "/action.php",
  //             type: "POST",
  //             data: {href: href, file_type: file_type, title: title} ,
  //             success: function (response) {
  //                 if(response)
  //                 {
  //                 }
  //             },
  //             error: function(jqXHR, textStatus, errorThrown) {
  //                console.log(textStatus, errorThrown);
  //             }
  //         });
		// });

		// Get and add audio counts
		// jQuery(".get_audio_counts").click(function (){
		// 	var href 		= $(this).attr('href');
		// 	var file_type 	= "1";
		// 	var title 		= $(this).attr('title');
		// 	$.ajax({
  //             url: "/action.php",
  //             type: "POST",
  //             data: {href: href, file_type: file_type, title: title} ,
  //             success: function (response) {
  //                 if(response)
  //                 {
  //                 }
  //             },
  //             error: function(jqXHR, textStatus, errorThrown) {
  //                console.log(textStatus, errorThrown);
  //             }
  //         });
		// });

		// Get PDF counts
		// jQuery(".get_pdf_counts").click(function (){
		// 	var href 		= $(this).attr('href');
		// 	var file_type 	= "0";
		// 	var title 		= $(this).attr('title');
		// 	$.ajax({
  //             url: "/action.php",
  //             type: "POST",
  //             data: {href: href, file_type: file_type, title: title} ,
  //             success: function (response) {
  //                 if(response)
  //                 {
  //                 }
  //             },
  //             error: function(jqXHR, textStatus, errorThrown) {
  //                console.log(textStatus, errorThrown);
  //             }
  //         });
		// });

		// function get_files_counts(name, title, file_type)
		// {
		// 	alert(name);
		// 	$.ajax({
	 //              url: "action.php",
	 //              type: "POST",
	 //              data: {name: name, title: title, file_type: file_type} ,
	 //              success: function (response) {
	 //                  if(response)
	 //                  {
	 //                  	alert(response);
	 //                  	console.log(response); return false;
	 //                    //$(".ShowData").html(response);
	 //                    //$("#view_dialog").modal('show');
	 //                  }
	 //              },
	 //              error: function(jqXHR, textStatus, errorThrown) {
	 //                 console.log(textStatus, errorThrown);
	 //              }
	 //          });
		// }
		$(".masham1705").parent('ul').css('margin-left', '0px');
		$(".masham1705").parent().addClass('masham_paragraph');
		$(".masham1705").children('a').addClass('masham_anchor');
	});
</script>

<style type="text/css">
	<?php if($page_name == "hobbes"){ ?>
		.epub_version {
		    float: left;
		    margin-top: -34px;
		    /* margin-right: -48px; */
		    color: #86b918;
		    padding-left: 109px;
		}

		.mobi_version {
		    color: #FFA500;
		    padding-left: 226px;
		    float: left;
		    clear: both;
		    margin-top: -34px;
		}
	<?php } elseif($page_name == "descartes") { ?>
		.epub_version {
		    float: right;
		    margin-top: -32px;
		    margin-right: 44px;
		    color: #86b918;
		}
		.mobi_version {
		    color: #FFA500;
		    padding-left: 10px;
		}
	<?php } elseif($page_name == "locke"){ ?>
		.epub_version {
		    float: right;
		    margin-top: -32px;
		    margin-right: 73px;
		    color: #86b918;
		}
	<?php } ?>
	.epub_descartes1637{
		float: right;
	    margin-top: -36px;
	    color: #86b918;
	    width: 226px;
	    padding-left: 10px;
	}
	.mobi_descartes1637{
		color: #FFA500;
		padding-left: 10px;
	}
	.epub_descartes1642{
	    float: left;

	    margin-top: 0px;

	    color: #86b918;

	    margin-right: 0px;

	}
	.mobi_descartes1642{
		color: #FFA500;
		padding-left: 10px;
	}
	.epub_descartes1644{
	    float: right;

	    margin-top: -24px;

	    color: #86b918;

	    width: 226px;

	    padding-left: 65px;

	}
	.mobi_descartes1644{
		color: #FFA500;
		padding-left: 10px;
	}
	.epub_descartes1619{
	    float: right;

	    margin-top: -24px;

	    color: #86b918;

	    width: 214px;

	    padding-left: 70px;

	    margin-right: 0px;

	}
	.mobi_descartes1619{
		color: #FFA500;
		padding-left: 10px;
	}
	.epub_locke1690{

	    float: right;

	    margin-top: -32px;

	    margin-right: 66px;

	    color: #86b918;

	}
	.epub_descartes1643{

		float: left;

	    margin-top: 0px;

	    margin-right: 0px;

	    color: #86b918;

	}
	.epub_bentham1780{

		float:left;

	    margin-top: -24px;

	    margin-right: 0px;

	    color: #86b918;
	    padding-left: 38px;

	}

	.mobi_bentham1780{
		color: #FFA500;
	    margin-top: -24px;
	    float: right;
	    /* padding-left: 146px; */
	    padding-right: 270px;
	}

	.epub_berkeley1710{

		float: right;

	    margin-top: -24px;

	    margin-right: 0px;

	    color: #86b918;
	    padding-left: 38px;

	}

	.mobi_berkeley1710{
		color: #FFA500;
    	margin-top: -24px;
	}
	.epub_berkeley1713{

		float: left;
	    margin-top: 0px;
	    margin-right: 0px;
	    color: #86b918;
	}

	.mobi_berkeley1713{
		color: #FFA500;
    	margin-top: -24px;
	}
	.epub_hume1739{
		float: right;
	    margin-top: -32px;
	    margin-right: 146px;
	    color: #86b918;
	}.epub_hume1748{
		margin-top: -29px;
		color: #86b918;
		margin-top: 1px;
		float: left;
		margin-right: 7px;
	}
	.mobi_hume1748{
		color: #FFA500;
		padding-left: 0px;
	}
	.epub_hume1779{
		color: #86b918;
		margin-top: 1px;
		float: left;
		margin-right: 7px;
	}
	.mobi_hume1779{
		color: #FFA500;
		padding-left: 0px;
	}
	.epub_kant1785{
		color: #86b918;
		float: left;
		margin-top: 0px;
		margin-right: 0px;
	}
	.mobi_kant1785{
		color: #FFA500;
		padding-left: 5px;
	}
	.epub_leibniz1680{
	    margin-top: -29px;
		float: none;
		margin-right: 0px;
	}
	.mobi_leibniz1680{
		color: #FFA500;
		padding-left: 10px;
	}
	.epub_leibniz1705{
		margin-top: -29px;
		float: none;
		margin-right: 0px;
	}
	.epub_leibniz1686d{
		margin-top: -29px;
		float: none;
		margin-right: 0px;
	}
	.epub_leibniz1714b{
		margin-top: -29px;
		float: none;
		margin-right: 0px;
	}
	.epub_bacon1620{
		margin-top: -29px;
		float: none;
		margin-right: 0px;
	}
	.one_line{
		margin-top: -29px;
		float: none;
		margin-right: 0px;
	}
	.epub_hobbes1651{
		margin-right: 4px;
		float: none;
		padding-left: 5px;
	}
	.mobi_hobbes1651{
		padding-left: 0px;
		float: none;
		margin-top: 0px;
	}
	.masham1705{
		font-weight: bold !important;
		list-style: disc !important;
		color: #282828 !important;
		padding-left: 0px !important;
	}
	.masham_paragraph p { 
		margin-left: 0px !important; 
	}
	.masham_anchor{
		font-weight: normal;
	}
	.bracket{
		color: #282828 !important;
	}
	.masham_title{
		font-weight: normal !important;
	}
</style>
