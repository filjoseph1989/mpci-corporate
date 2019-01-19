//login effect
$(document).ready(function(){
  $(".login-close").click(function(){
    $("#mpci-login-form").slideUp("slow");
  });
});
$(document).ready(function(){
	$(".login").click(function(){
		$("#mpci-login-form").slideDown("slow");
	});
});
$(document).ready(function(){
  $(".contact-close").click(function(){
    $(".mpci-admin-tinymce").slideUp("slow");
  });
});
$(document).ready(function(){
  $(".signup-close").click(function(){
    $("#mpci-signup").slideUp("slow");
  });
});
$(document).ready(function(){
  $(".admin-close").click(function(){
    $("#mpci-admin").slideUp("slow");
  });
});

//this will prevent scrolling to top
//when <a href="#"> is click
$(document).ready(function(){
	$('a[href^="#"]').click(function(e) {
		e.preventDefault();
	});
});
