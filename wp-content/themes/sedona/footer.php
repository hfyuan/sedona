			<footer>
			<nav id="footernavmobile">
				<a href="http://www.jbg.com/" id="jbg-link">The JBG Company</a>
				<a href="equal-housing-notice/" id="equal-housing">Equal Housing</a>
				<span id="sec508">&nbsp;-</span>
				<ul>
				<li><a href="http://www.sedona-slate.com/privacy-policy/" id="privacy">Privacy Policy</a></li>
				<li><a id="privacy" href="<?php echo home_url(); ?>/resident-login">Resident Login</a></li>
				<li><a id="privacy" href="<?php echo home_url(); ?>/neighborhood">1510 Clarendon Boulevard Arlington, VA 22209</a></li>
                <li style="color:#fff;">Phone: 1.866.997.4146</li>
				</ul>
			</nav>
            </footer>

			<?php if(!is_front_page()) { // if is not the homepage allow these version of footer icons if its homepage its the above ones ?>
			<footer>
				<nav>
				<?php wp_nav_menu ('menu=second-menu'); ?>
				</nav>
			</footer>
			<?php } ?>
		
		</div> <!-- end #container -->

</div> <!-- wrap -->
				
		<!--[if lt IE 7 ]>
  			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->


		<?php wp_footer(); // js scripts are inserted using this function ?>

		<!-- <script src="js/main.js"></script> -->

		<script type="text/javascript">	
			jQuery(document).ready(function ($) { //noconflict for WP
						
			$("a[href^='http://']:not([href*='"+location.hostname+"']), [href^='https://']:not([href*='"+location.hostname+"'])")
				.attr("target","_blank")
				.click(function(e) {
				  return confirm('You will be directed to an external site.'); 
				});

			});  //noconflict closed

		</script>
		<script type="text/javascript"
		src="http://popcard.ltsolutions.com/js/DynamicCampaign.js"></script>
		<script>
			//start dynamic phone numbering
			setDynamicCampaign('3691', 'LTSDynamicCampaignText', false, '');
			function setDynamicCampaignProcessCompleted(dynamicCampaignResponse) {
			if(dynamicCampaignResponse.successFlag == true) {
			if(dynamicCampaignResponse.controlIDUpdated == 'LTSDynamicCampaignText'){
			//grab the control from the document object
			var objControlIDUpdated =          
			document.getElementById(dynamicCampaignResponse.controlIDUpdated);
			//you can style the formatted campaign differently
			//or perform any other action based on the campaign
			objControlIDUpdated.innerText =
			dynamicCampaignResponse.formattedCampaign;
			}
			}
			else {
			alert(dynamicCampaignResponse.errorMessage);
			}
			}

		</script>
		
	</body>

</html>
