<?php
/*
	Plugin Name: Warn On Leave
	Plugin URI: http://www.q2apro.com/plugins/warn-on-leave
	Plugin Description: Warns the user after he entered text in textarea or CKEditor and is leaving the page
	Plugin Version: 1.0
	Plugin Date: 2014-02-26
	Plugin Author: q2apro.com
	Plugin Author URI: http://www.q2apro.com
	Plugin License: GPLv3
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI: https://raw.github.com/q2apro/q2a-comment-to-answer/master/qa-plugin.php
	
	This program is free software. You can redistribute and modify it 
	under the terms of the GNU General Public License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.gnu.org/licenses/gpl.html

*/

	class qa_html_theme_layer extends qa_html_theme_base {
		
		function head_script()
		{
			// default call
			qa_html_theme_base::head_script();
			
			if(($this->template=='ask' || $this->template=='question') && qa_opt('q2apro_warnonleave_enabled')) {
				$this->output('<script type="text/javascript">
				$(document).ready(function(){
				
					var warn_on_leave = false;
					
					// for content fields
					$(".qa-main textarea").keyup( function() {
						warn_on_leave = true;
					});
					
					// let submit through
					$("input:submit").click( function() {
						warn_on_leave = false;
						return true;
					});
				
					// for CKEditor fields
					if(typeof(CKEDITOR) !== "undefined") {
						CKEDITOR.on("currentInstance", function() {
							try {
								CKEDITOR.currentInstance.on("key", function() {
									warn_on_leave = true;
								});
							} catch (err) { }
						});
					}
					
					// show popup when leaving
					$(window).bind("beforeunload", function() {
						if(warn_on_leave) {
							return "'.qa_lang('q2apro_warnonleave_lang/warnmsg').'";
						}
					});
				}); // end ready
				</script>');
			}
		}
		
	} // end qa_html_theme_layer
	

/*
	Omit PHP closing tag to help avoid accidental output
*/
