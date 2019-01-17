
function suggestme(inputString,e)
{
//alert("hello");
if(e.keyCode==40 || e.keyCode==38){
return false;
}
if(inputString.length == 0) {
			$('#suggestme').fadeOut();
} else 
{
	
	$.post("process.php", {"name": ""+inputString+""}, function(data){
			if(data.length >0) {
					$('#suggestme').fadeIn();					
					$('#suggestmeList').html(data);
					
					$(document).ajaxStop(function(){
						var chosen="";
						$("#SearchBox").keydown(function(e){
							var list = $(this);   
							if(e.keyCode==40){
								if(chosen === "") {
										chosen = 0;
									} else if((chosen+1) < $('.searchsugg li').length) {
										chosen++; 
									}								
								 $('.searchsugg li').removeClass('active');
								  $('.searchsugg li:eq('+chosen+')').addClass('active');
								  $('#SearchBox').val($('.searchsugg li:eq('+chosen+')').text());
								return false;
							}
							else if(e.keyCode==38){
								 if(chosen === "") {
									chosen = 0;
								} else if(chosen > 0) {
									chosen--;            
								}
								$('.searchsugg li').removeClass('active');
								$('.searchsugg li:eq('+chosen+')').addClass('active');
								$('#SearchBox').val($('.searchsugg li:eq('+chosen+')').text());
								return false;
							}
							
						});
					});
					
				}
			});
		}
}
function fillSearch(val)
{
//alert("hi");
	$("#searchtext").val(val);
	$("#SearchForm").submit();
	setTimeout("$('#suggestme').fadeOut();", 600);
}
$(document).ready(function(){
$("#SearchForm").mouseleave(function(){setTimeout("$('#suggestme').fadeOut();", 600);});
});