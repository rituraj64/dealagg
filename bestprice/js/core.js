jQuery(document).ready(function()
			{
				

					jQuery('.genie-input').focus(function()
							{
						if(jQuery(this).attr('value')=='Enter Exact Product Name')
						{
						jQuery(this).attr('value','');
						}
							});
						jQuery('.genie-input').blur(function()
								{
							if(jQuery(this).attr('value')=='')
							{
							jQuery(this).attr('value','Enter Exact Product Name');
							}
						
							});
			});		