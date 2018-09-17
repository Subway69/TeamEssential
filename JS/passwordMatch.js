

document.addEventListener("DOMContentLoaded", function() {

	var checkPassword = function(str)
	{
	  var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
	  return re.test(str);
	};

	var checkForm = function(e){
		if(this.tPassword.value != "" && this.tPassword.value == this.tConfirm.value) {
			if(!checkPassword(this.tPassword.value)) {
				alert("The password you have entered is not valid!");
				this.tPassword.focus();
				e.preventDefault();
				return;
			}
		} else {
			alert("Error: Please check that you've entered and confirmed your password!");
			this.tPassword.focus();
			e.preventDefault();
			return;
		}
		alert("Both username and password are VALID!");
	};

	var regform = document.getElementById("reg");
	regform.addEventListener("submit", checkForm, true);

	var supports_input_validity = function(){
	  var i = document.createElement("input");
	  return "setCustomValidity" in i;
	}

	if(supports_input_validity()) {

		var pwd1Input = document.getElementById("field_pwd1");
		pwd1Input.setCustomValidity(pwd1Input.title);

		var pwd2Input = document.getElementById("field_pwd2");

		pwd1Input.addEventListener("keyup", function(e) {
			this.setCustomValidity(this.validity.patternMismatch ? pwd1Input.title : "");
			
			if(this.checkValidity()) {
				pwd2Input.pattern = RegExp.escape(this.value);
				pwd2Input.setCustomValidity(pwd2Input.title);
			} else {
				pwd2Input.pattern = this.pattern;
				pwd2Input.setCustomValidity("");
			}
		}, false);

		pwd2Input.addEventListener("keyup", function(e) {
			this.setCustomValidity(this.validity.patternMismatch ? pwd2Input.title : "");
		}, false);
	}
}, false);

if(!RegExp.escape) {
	RegExp.escape = function(s) {
		return String(s).replace(/[\\^$*+?.()|[\]{}]/g, '\\$&');
	};
}

								