$(function() {
	$(".dropdown").each(function(idx, item) {
		$(item).find(".dropdown-menu li a").on("click", function() {

			var thClass = $(this).attr('class');

			if(thClass == "bank") {

				if($(this).text() == "직접입력") {
					var thHtml = "<input type='text' class='btn' name='"+thClass+"2' placeholder='직접입력'/>";

					$(this).closest(".dropdown").find("button").remove();
					$(this).closest(".dropdown").find("input[name='"+thClass+"2']").remove();

					$(this).closest(".dropdown").find("ul").before(thHtml);
					$(this).closest(".dropdown").find('input[name="'+thClass+'2"]').focus();

					$(this).closest(".dropdown").find(".dropdown-menu").slideToggle("fast");

					event.preventDefault();
				} else {
					var thTxt = $(this).text();
					var thHtml = '<button type="button" class="btn">'+thTxt+'<span class="pull-right">▼</span></button>';

					$(this).closest(".dropdown").find("input[name='"+thClass+"2']").remove();
					$(this).closest(".dropdown").find("button").remove();

					$(this).closest(".dropdown").find("ul").before(thHtml);
					$(this).closest(".dropdown").find(".btn").addClass("on");
					$(this).closest(".dropdown").find(".dropdown-menu").slideToggle("fast");
					event.preventDefault();
				}
			} else {
				var thTxt = $(this).text();
				var thHtml = thTxt + "<span class='pull-right'>▼</span>";
				$(this).closest(".dropdown").find(".btn").html(thHtml);
				$(this).closest(".dropdown").find(".btn").addClass("on");
				$(this).closest(".dropdown").find(".dropdown-menu").slideToggle("fast");
				event.preventDefault();
			}
		});
	});
});