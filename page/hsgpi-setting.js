function _hsgpi_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_hsgpi_display.action="options-general.php?page=horizontal-scroll-google-picasa-images&ac=del&did="+id;
		document.frm_hsgpi_display.submit();
	}
}

function _hsgpi_submit()
{
	if(document.hsgpi_form.hsgpi_googleusername.value == "")
	{
		alert("Enter your google plus user id.")
		document.hsgpi_form.hsgpi_googleusername.focus();
		return false;
	}
	else if(document.hsgpi_form.hsgpi_googlealbumid.value == "")
	{
		alert("Enter google plus album id.")
		document.hsgpi_form.hsgpi_googlealbumid.focus();
		return false;
	}
	else if(document.hsgpi_form.hsgpi_title.value == "")
	{
		alert("Enter title for your gallery.")
		document.hsgpi_form.hsgpi_title.focus();
		return false;
	}
	else if((document.hsgpi_form.hsgpi_intervaltime.value=="") || isNaN(document.hsgpi_form.hsgpi_intervaltime.value))
	{
		alert("Enter auto interval time in millisecond, only number. (Ex: 1500)")
		document.hsgpi_form.hsgpi_intervaltime.focus();
		return false;
	}
	else if((document.hsgpi_form.hsgpi_animation.value=="") || isNaN(document.hsgpi_form.hsgpi_animation.value))
	{
		alert("Enter animation duration in millisecond, only number. (Ex: 1000)")
		document.hsgpi_form.hsgpi_animation.focus();
		return false;
	}
	else if((document.hsgpi_form.hsgpi_googleimgcount.value=="") || isNaN(document.hsgpi_form.hsgpi_googleimgcount.value))
	{
		alert("Number of photos, below 20 is recommended count.")
		document.hsgpi_form.hsgpi_googleimgcount.focus();
		return false;
	}
}

function _hsgpi_redirect()
{
	window.location = "options-general.php?page=horizontal-scroll-google-picasa-images";
}

function _hsgpi_help()
{
	window.open("http://www.gopiplus.com/work/2014/04/26/horizontal-scroll-google-picasa-images-wordpress-plugin/");
}