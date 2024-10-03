<?php
include 'conn.php';
include 'Frame.php';
$page_name = basename($_SERVER['REQUEST_URI']);
$frame = new Frame();

$frame->route('/', 'home');
$frame->route('/texts', 'texts');
$frame->route('/authors/(.*)', 'authors');
$frame->route('/faqs', 'faqs');
$frame->route('/faqs/(.*)', 'answer');
$frame->route('/bennett/(.*)', 'bennett');
$frame->route('/comments', 'comments');
$frame->route('/contact', 'contact');
$frame->route('/audio', 'audio');
$frame->route('/mwaudio', 'mwaudio');
$frame->route('/dhaudio', 'dhaudio');
$frame->route('/rdaudio', 'rdaudio');
$frame->route('/jsmaudio', 'jsmaudio');
$frame->route('/jlaudio', 'jlaudio');
$frame->route('/thaudio', 'thaudio');
$frame->route('/th2audio', 'th2audio');
$frame->route('/sdgaudio', 'sdgaudio');
$frame->route('/search', 'search');
$frame->route('/gwlaudio', 'gwlaudio');
$frame->route('/testme', 'testme');


include 'Controller.php';

$frame->run();
?>

<!-- Default Statcounter code for early modern texts
http://earlymoderntexts.com -->
<script type="text/javascript">
var sc_project=11732800; 
var sc_invisible=1; 
var sc_security="4148e714"; 
</script>
<script type="text/javascript"
src="https://www.statcounter.com/counter/counter.js"
async></script>
<noscript><div class="statcounter"><a title="Web Analytics"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="//c.statcounter.com/11732800/0/4148e714/1/" alt="Web
Analytics"></a></div></noscript>
<!-- End of Statcounter Code -->

<input type="hidden" id="current_page_name" value="<?php echo $page_name; ?>">
<script type="text/javascript" src="/assets/js/jquery-3.2.1.min.js"></script>
<script src="http://static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">
	// Get all files couts

	jQuery(document).ready(function () {
		// Selected nav bar
		var page_name = "";
			page_name = jQuery("#current_page_name").val();
		if(page_name == "audio" || page_name == "mwaudio" || page_name == "dhaudio" || page_name == "rdaudio" || page_name == "thaudio" || page_name == "th2audio" || page_name == "jlaudio")
			jQuery("#audio_selected").addClass("selected");
		else if(page_name == "contact")
			jQuery("#contact_selected").addClass("selected");
		else if(page_name == "comments")
			jQuery("#comments_selected").addClass("selected");
		else if(page_name == "faqs")
			jQuery("#faqs_selected").addClass("selected");
		else if(page_name == "texts")
			jQuery("#texts_selected").addClass("selected");
		else 
			jQuery("#home_selected").addClass("selected");
		// Get page counts
		jQuery(".get_page_name").click(function (){
			var href 		= $(this).attr('href');
			var file_type 	= "2";
			var title 		= $(this).attr('title');
			$.ajax({
              url: "/action.php",
              type: "POST",
              data: {href: href, file_type: file_type, title: title} ,
              success: function (response) {
                  if(response)
                  {
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
              }
          });
		});	

		// Get and add audio counts
		jQuery(".get_audio_counts").click(function (){
			var href 		= $(this).attr('href');
			var file_type 	= "1";
			var title 		= $(this).attr('title');
			$.ajax({
              url: "/action.php",
              type: "POST",
              data: {href: href, file_type: file_type, title: title} ,
              success: function (response) {
                  if(response)
                  {
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
              }
          });
		});	

		// Get PDF counts
		jQuery(".get_pdf_counts").click(function (){
			var href 		= $(this).attr('href');
			var file_type 	= "0";
			var title 		= $(this).attr('title');
			$.ajax({
              url: "/action.php",
              type: "POST",
              data: {href: href, file_type: file_type, title: title} ,
              success: function (response) {
                  if(response)
                  {
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
              }
          });
		});

		function get_files_counts(name, title, file_type)
		{
			alert(name);
			$.ajax({
	              url: "action.php",
	              type: "POST",
	              data: {name: name, title: title, file_type: file_type} ,
	              success: function (response) {
	                  if(response)
	                  {
	                  	alert(response); 
	                  	console.log(response); return false;
	                    //$(".ShowData").html(response);
	                    //$("#view_dialog").modal('show');
	                  }
	              },
	              error: function(jqXHR, textStatus, errorThrown) {
	                 console.log(textStatus, errorThrown);
	              }
	          });
		}
	});
</script>
