<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
	<defs>
		<filter id="goo">
		  <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
		  <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 35 -10" result="goo" />
		  <feBlend in="SourceGraphic" in2="goo" operator="atop" />
		</filter>
	</defs>
</svg>
<div class="loader" id="loader">
	<div></div>
	<div></div>
	<div></div>
	<div></div>
	<div></div>
</div>

<script>
	var myVar;

	function myFunction() {
	  myVar = setTimeout(showPage, 3000);
	}

	function showPage() {
	  document.getElementById("loader").style.display = "none";
	  document.getElementById("myDiv").style.display = "block";
	}
</script>